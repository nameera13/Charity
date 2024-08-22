<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use App\Mail\WebsiteEmail;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.main.home.dashboard');
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if(Auth::guard('admin')->attempt($data)){
            return redirect(url('admin/dashboard'))->with('success','Admin Login Successfully!');
        }else{
            return redirect(url('admin/login'))->with('error','Invalid Credentials');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(url('admin/login'))->with('success','Admin Logout Successfully!');
    }

    public function forget_password()
    {
        return view('admin.auth.forget-password');
    }

    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);        

        $data = Admin::where('email',$request->email)->first();
        if (!$data) {
            return redirect()->back()->with('error','Email Not Found');
        }

        $token = hash('sha256',time());
        $data->token = $token;
        $data->update();

        $reset_link = url('admin/reset-password/'.$token.'/'.$request->email);
        $subject = "Reset Password!";
        $message = "Please click on below link to reset your password<br><br>";
        $message .= "<a href='".$reset_link."'>Click Here</a>";

        \Mail::to($request->email)->send(new WebsiteEmail($subject, $message));

        return redirect()->back()->with('success','Reset Password link sent on your email');

    }

    public function reset_password($token,$email)
    {
        $data = Admin::where('email',$email)->where('token',$token);
        if(!$data){
            return redirect(url('admin/login'))->with('error','Invalid token or email');
        }
        return view('admin.auth.reset-password',compact('token','email'));
    }

    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $data = Admin::where('email',$request->email)->where('token',$request->token)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Your token has expired.');
        }
    
        $data->password = Hash::make($request->password);
        $data->token = '';
        $data->update();

        return redirect(url('admin/login'))->with('success','Password reset Successfully!');
    }

    public function profile()
    {
        return view('admin.main.profile.index');
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]); 

        $data = Admin::find(Auth::guard('admin')->user()->id);
        
        if ($request->photo != null) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png',
            ]);    

            if (Auth::guard('admin')->user()->photo != null) {
                unlink(public_path('uploads/profile/'.Auth::guard('admin')->user()->photo));
            }

            $final_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/profile'), $final_name);
            $data->photo = $final_name;

        } 
    
        if($request->password != '' || $request->confirm_password != ''){
            $request->validate([
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);

            $data->password = Hash::make($request->password);
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->update();


        return redirect()->back()->with('success','Profile Updated Successfully!');
    }
}
