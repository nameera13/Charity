<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventTicket;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class EventTicketController extends Controller
{
    public function __construct(EventTicket $model)
    {
        $this->moduleName = "Event Ticket";
        $this->model = $model;
        $this->moduleRoute = url('admin/event-ticket');
        $this->moduleView = "admin.main.event";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

   
    public function tickets($id)
    {
        $event = Event::find($id);
        return view('admin.main.event.tickets', compact('event'));
    }

    public function getDataTable(Request $request)
    {
        $eventId = $request->input('event_id'); 
        $result = $this->model->where('event_id', $eventId)
                    ->select('event_tickets.*', 'users.name as user_name')
                    ->where('payment_status','Completed')
                    ->leftjoin('users','event_tickets.user_id', '=', 'users.id');
    
        $result = $result->orderBy("event_tickets.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function ticketInvoice(string $id)
    {
        $event_ticket = EventTicket::find($id);
        $user_data = User::find($event_ticket->user_id);
        return view('admin.main.event.invoice', compact('event_ticket', 'user_data'));
    }
}
