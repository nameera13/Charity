<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cause;
use App\Models\CausePhoto;
use App\Models\CauseVideo;
use App\Models\CauseFaq;
use App\Models\CauseDonation;
use App\Models\Admin;
use App\Mail\WebsiteEmail;
use Razorpay\Api\Api;

class CausesController extends Controller
{
    public function index()
    {
        $causes = Cause::get();
        return view('front.causes', compact('causes'));
    }

    public function details($slug)
    {
        $cause = Cause::where('slug',$slug)->first();
        $cause_photos = CausePhoto::where('cause_id',$cause->id)->get();
        $cause_videos = CauseVideo::where('cause_id',$cause->id)->get();
        $cause_faqs = CauseFaq::where('cause_id',$cause->id)->get();
        $recent_causes = Cause::orderBy('id','desc')->take(5)->get();
        return view('front.cause_detail',compact('cause', 'cause_photos', 'cause_videos', 'cause_faqs', 'recent_causes'));
    }

    public function send_message(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile_no' => 'required',
            'message' => 'required'
        ]);

        $admin_data = Admin::where('id',1)->first();
        $admin_email = $admin_data->email;

        $data = Cause::where('id',$request->cause_id)->first();

        $subject = "Message from visitor for Cause - ".$data->name;
        $message = "<b>Visitor Information:</b><br><br>";
        $message.= "Name: ".$request->name."<br>";
        $message.= "Email: ".$request->email."<br>";
        $message.= "Mobile No: ".$request->mobile_no."<br>";
        $message.= "Message: ".$request->message."<br><br>";
        $message .= "<b>Cause Page URL:</b><br>";
        $message.= "<a href='".url('causes/'.$data->slug)."'>".url('causes/'.$data->slug)."</a>";

        \Mail::to($admin_email)->send(new WebsiteEmail($subject,$message));

        return redirect()->back()->with('success','Message sent Successfully!');
    }

    public function payment(Request $request)
    {
        $cause_data = Cause::where('id', $request->cause_id)->first();

        if (!$cause_data) {
            return redirect()->back()->with('error', 'Cause not found.');
        }


        $needed_amount = $cause_data->goal - $cause_data->raised;

        
        if ($request->price > $needed_amount) {
            return response()->json(['error' => 'You cannot donate more than ₹' . $needed_amount . '. You need at least ₹' . $needed_amount . ' to meet the goal.'], 400);
        }
        

        if ($request->payment_method == 'Razorpay') {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $orderData = [
                'amount' => $request->price * 100,
                'currency' => 'INR',
                'receipt' => 'receipt_' . uniqid(),
                'payment_capture' => 1 
            ];
            
            try {
                $order = $api->order->create($orderData);

                session()->put('cause_id', $request->cause_id);
                session()->put('price', $request->price);
                session()->put('return_url', route('donation_payment_success')); 
                session()->put('cancel_url', route('donation_payment_cancel')); 


                return response()->json([
                    'order_id' => $order->id,
                    'razorpay_key' => env('RAZORPAY_KEY'),
                    'amount' => $request->price * 100,
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

            $donation = new CauseDonation;
            $donation->cause_id = session()->get('cause_id');
            $donation->user_id = auth()->user()->id;
            $donation->price = session()->get('price');
            $donation->currency = 'INR';
            $donation->payment_id = $request->razorpay_payment_id;
            $donation->payment_method = "Razorpay";
            $donation->payment_status = "Completed";
            $donation->save();

            // Update event data
            $cause_data = Cause::where('id', session()->get('cause_id'))->first();
            $cause_data->raised += session()->get('price');
            $cause_data->update();

            // Clear session data
            session()->forget(['cause_id', 'price', 'razorpay_order_id']);

            return redirect('causes/' . $cause_data->slug)->with('success', 'Payment completed successfully');
        } catch (\Exception $e) {
            return redirect('donation/payment-cancel')->with('error', 'Payment verification failed. Please try again.');
        }
    }

    public function payment_cancel()
    {
        return redirect('/')->with('error','Payment is cancelled');
    }

    
}
