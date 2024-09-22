<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventPhoto;
use App\Models\EventVideo;
use App\Models\Admin;
use App\Mail\WebsiteEmail;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::get();
        return view('front.events',compact('events'));
    }

    public function details($slug)
    {
        $event = Event::where('slug',$slug)->first();
        $event_photos = EventPhoto::where('event_id',$event->id)->get();
        $event_videos = EventVideo::where('event_id',$event->id)->get();
        $recent_events = Event::orderBy('id','desc')->take(5)->get();
        return view('front.event_details',compact('event','event_photos','event_videos','recent_events'));
    }

    public function enquery(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $admin_data = Admin::where('id',1)->first();
        $admin_email = $admin_data->email;

        $data = Event::where('id',$request->event_id)->first();

        $subject = "Message from visitor for Event - ".$data->name;
        $message = "<b>Visitor Information:</b><br><br>";
        $message.= "Name: ".$request->name."<br>";
        $message.= "Email: ".$request->email."<br>";
        $message.= "Mobile No: ".$request->mobile_no."<br>";
        $message.= "Message: ".$request->message."<br><br>";
        $message .= "<b>Event Page URL:</b><br>";
        $message.= "<a href='".url('events/'.$data->slug)."'>".url('events/'.$data->slug)."</a>";

        \Mail::to($admin_email)->send(new WebsiteEmail($subject,$message));

        return redirect()->back()->with('success','Enquery sent Successfully!');
    }

}
