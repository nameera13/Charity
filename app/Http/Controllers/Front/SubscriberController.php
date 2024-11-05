<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Mail\WebsiteEmail;

class SubscriberController extends Controller
{
    public function subscriber(Request $request)
    {
        $subscriber = new subscriber();
        $subscriber->email = $request->email;
        $subscriber->token = md5(time().$request->email);
        $subscriber->status = 0;
        $subscriber->save();

        $subject = "Subscriber Verification";
        $message = "Please verify your email address by clicking on the following link:<br><br>";
        $message .= "<a href='".url('subscriber-verify',[$request->email,$subscriber->token])."'>". 
        url('subscriber-verify', [$request->email,$subscriber->token]) ."</a><br><br>";

        \Mail::to($request->email)->send(new WebsiteEmail($subject, $message));
        return redirect()->back()->with('success', 'An email has been sent to you, Please check and verify your email');
    }

    public function subscriber_verify($email, $token)
    {
        $subscriber = Subscriber::where('email',$email)->where('token',$token)->first();
        if ($subscriber){
            $subscriber->status = 1;
            $subscriber->token = '';
            $subscriber->save();

            return redirect('/')->with('success','Your email has been verified successfully!');
        } else {
            return redirect('/')->with('error','Invalid email or token');
        }
    }
}
