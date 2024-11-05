<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use App\Mail\WebsiteEmail;

class SubscribersController extends Controller
{
    public function __construct(Subscriber $model)
    {
        $this->moduleName = "Subscriber";
        $this->model = $model;
        $this->moduleRoute = url('admin/subscribers');
        $this->moduleView = "admin.main.subscrbers";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        return view('admin.main.subscribers.index');
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select('subscribers.*');

        $result = $result->orderBy("subscribers.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function send_message()
    {
        return view('admin.main.subscribers.send_message');
    }

    public function send_message_submit(Request $request)
    {
        $subscribers = Subscriber::where('status',1)->get();

        $subject = $request->subject;
        $message = $request->content;

        foreach ($subscribers as $key => $value) {
            \Mail::to($value->email)->send(new WebsiteEmail($subject, $message));
        }

        return redirect()->back()->with('success', 'Message Sent Successfully!');
    }

    public function destroy($id)
    {
        $subscribers = Subscriber::find($id);
        $subscribers->delete();

        return redirect()->back()->with('success', 'Subscriber deleted Successfully!');
    }
}
