<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventPhoto;
use App\Models\EventVideo;
use App\Models\EventTicket;
use App\Models\Admin;
use App\Mail\WebsiteEmail;
use Razorpay\Api\Api;

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

    
    public function payment(Request $request)
    {
        $event_data = Event::where('id', $request->event_id)->first();

        if (!$event_data) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        if ($event_data->total_seat > 0) {
            $remaining_seat = $event_data->total_seat - $event_data->booked_seat;
            if ($event_data->booked_seat + $request->number_of_tickets > $event_data->total_seat) {
                return redirect()->back()->with('error', 'Sorry, only ' . $remaining_seat . ' tickets/seats are available');
            }
        }

        $total_price = $request->number_of_tickets * $request->unit_price;

        if ($total_price <= 0) {
            return redirect()->back()->with('error', 'Total price must be greater than zero.');
        }

        if ($request->payment_method == 'Razorpay') {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $orderData = [
                'amount' => $total_price * 100, 
                'currency' => 'INR',
                'receipt' => 'receipt_' . uniqid(),
                'payment_capture' => 1 
            ];
            
            try {
                $order = $api->order->create($orderData);

                session()->put('event_id', $request->event_id);
                session()->put('unit_price', $request->unit_price);
                session()->put('number_of_tickets', $request->number_of_tickets);
                session()->put('total_price', $total_price);
                session()->put('return_url', route('event_ticket_razorpay_success')); 
                session()->put('cancel_url', route('event_ticket_cancel')); 

                return response()->json([
                    'order_id' => $order->id,
                    'razorpay_key' => env('RAZORPAY_KEY'),
                    'amount' => $total_price * 100,
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to create Razorpay order: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Invalid payment method.');
    }


    public function payment_success(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);

            $obj = new EventTicket;
            $obj->event_id = session()->get('event_id');
            $obj->user_id = auth()->user()->id;
            $obj->unit_price = session()->get('unit_price');
            $obj->number_of_tickets = session()->get('number_of_tickets');
            $obj->total_price = session()->get('total_price');
            $obj->currency = 'INR'; 
            $obj->payment_id = $request->razorpay_payment_id;
            $obj->payment_method = "Razorpay";
            $obj->payment_status = 'Completed'; 
            $obj->save();

            // Update event data
            $event_data = Event::where('id', session()->get('event_id'))->first();
            $event_data->booked_seat += session()->get('number_of_tickets');
            $event_data->update();

            // Clear session data
            session()->forget(['event_id', 'unit_price', 'number_of_tickets', 'total_price']);

            return redirect('events/' . $event_data->slug)->with('success', 'Payment completed successfully');
        } catch (\Exception $e) {
            return redirect('events/ticket/payment-cancel')->with('error', 'Payment verification failed. Please try again.');
        }
    }

    public function free_booking(Request $request)
    {
        if(!auth()->user()) {
            return redirect()->route('login');
        }

        $request->validate([
            'number_of_tickets' => 'required'
        ]);

        $event_data = Event::where('id',$request->event_id)->first();

        if($event_data->total_seat > 0) {
            $remaining_seat = $event_data->total_seat - $event_data->booked_seat;
            if($event_data->booked_seat + $request->number_of_tickets > $event_data->total_seat) {
                return redirect()->back()->with('error','Sorry, only '.$remaining_seat.' tickets/seats are available');
            }
        }

        $total_price = $request->number_of_tickets * $request->unit_price;

        $obj = new EventTicket;
        $obj->event_id = $request->event_id;
        $obj->user_id = auth()->user()->id;
        $obj->unit_price = $request->unit_price;
        $obj->number_of_tickets = $request->number_of_tickets;
        $obj->total_price = $total_price;
        $obj->currency = "";
        $obj->payment_id = "payment_no_".time();
        $obj->payment_method = "Free";
        $obj->payment_status = "Completed";
        $obj->save();

        $event_data = Event::where('id',$request->event_id)->first();
        $event_data->booked_seat = $event_data->booked_seat + $request->number_of_tickets;
        $event_data->update();

        return redirect('events/' . $event_data->slug)->with('success','Booking completed successfully');

    }

    public function payment_cancel()
    {
        return redirect('/')->with('error','Payment is cancelled');
    }


}
