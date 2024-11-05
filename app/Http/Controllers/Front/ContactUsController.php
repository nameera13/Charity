<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Mail\WebsiteEmail;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('front.contact_us');
    }

    public function contact_us(Request $request)
    {
        $admin_data = Admin::where('id',1)->first();

        $subject = "Contact Us!";
        $message = "Visitor Information: <br><br>";
        $message .= "Name: <br>". $request->name ."<br><br>";
        $message .= "Email: <br>". $request->email ."<br><br>";
        $message .= "Message: <br>". $request->message ."<br><br>";

        \Mail::to($request->email)->send(new WebsiteEmail($subject, $message));

        return redirect()->back()->with('success','Message Sent Successfully!');

    }
}
