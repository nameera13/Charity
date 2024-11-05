<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\EventTicket;
use App\Models\Event;
use App\Models\Cause;
use App\Models\CauseDonation;
use Auth;
use Hash;
use DB;

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

    public function ticketDataTable(Request $request)
    {
        $result = DB::table('event_tickets')
                    ->select('event_tickets.*', 'events.name as event_name', 'events.slug as event_slug')
                    ->where('user_id', Auth::id())
                    ->where('payment_status','Completed')
                    ->leftjoin('users','event_tickets.user_id', '=', 'users.id')
                    ->leftjoin('events','event_tickets.event_id', '=', 'events.id');

    
        $result = $result->orderBy("event_tickets.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }
    
    public function ticketInvoice(string $id)
    {
        $event_ticket = EventTicket::findOrFail($id);
        $user_data = User::findOrFail($event_ticket->user_id);
        $event = Event::findOrFail($event_ticket->event_id);

        return response()->json([
            'payment_id' => $event_ticket->payment_id,
            'created_at' => $event_ticket->created_at->format('d M Y h:i A'),
            'user_data' => $user_data,
            'event' => $event,
            'unit_price' => $event_ticket->unit_price,
            'number_of_tickets' => $event_ticket->number_of_tickets,
            'total_price' => $event_ticket->total_price,
            'payment_method' => $event_ticket->payment_method,
        ]);
    }

    public function donationDataTable(Request $request)
    {
        $result = DB::table('cause_donations')
                    ->select('cause_donations.*', 'causes.name as cause_name', 'causes.slug as cause_slug')
                    ->where('user_id', Auth::id())
                    ->where('payment_status','Completed')
                    ->leftjoin('users','cause_donations.user_id', '=', 'users.id')
                    ->leftjoin('causes','cause_donations.cause_id', '=', 'causes.id');

    
        $result = $result->orderBy("cause_donations.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }
    
    public function donationInvoice(string $id)
    {
        $cause_donation = CauseDonation::findOrFail($id);
        $user_data = User::findOrFail($cause_donation->user_id);
        $cause = Cause::findOrFail($cause_donation->cause_id);

        return response()->json([
            'payment_id' => $cause_donation->payment_id,
            'created_at' => $cause_donation->created_at->format('d M Y h:i A'),
            'user_data' => $user_data,
            'cause' => $cause,
            'price' => $cause_donation->price,
            'payment_method' => $cause_donation->payment_method,
        ]);
    }


}
