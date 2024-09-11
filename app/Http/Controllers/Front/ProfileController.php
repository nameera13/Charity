<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class ProfileController extends Controller
{

    public function profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]); 

        $data = User::find(Auth::guard('web')->user()->id);
        
        if ($request->photo != null) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png',
            ]);    

            if (Auth::guard('web')->user()->photo != null) {
                unlink(public_path('front/uploads/profile/'.Auth::guard('web')->user()->photo));
            }

            $final_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('front/uploads/profile'), $final_name);
            $data->photo = $final_name;

        } 

        $data->name = $request->name;
        $data->email = $request->email;
        $data->update();


        return redirect()->back()->with('success','Profile Updated Successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ]);

        if (!Hash::check($request->old_password, Auth::guard('web')->user()->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect']);
        }

        $user = Auth::guard('web')->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

}
