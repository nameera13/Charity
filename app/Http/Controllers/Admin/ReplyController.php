<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use Auth;

class ReplyController extends Controller
{
    
    public function __construct(Reply $model)
    {
        $this->moduleName = "replies";
        $this->model = $model;
        $this->moduleRoute = url('admin/replies');

        $this->moduleView = "admin.main.reply";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        return view('admin.main.reply.index');

    }

    public function store(Request $request)
    {
        $result = new Reply();
        $result->comment_id = $request->comment_id;
        $result->reply = $request->reply;
        $result->name = Auth::guard('admin')->user()->name;
        $result->email = Auth::guard('admin')->user()->email;
        $result->user_type = 'Admin';
        $result->status = 'Active';

        $result->save();

        return response()->json(['message' => 'Reply Submitted Successfully!']);
    }

    public function getDataTable(Request $request)
    {
        $result = Reply::select('replies.*','comments.comment as comment','posts.title as post_name','posts.slug as slug')
                ->leftjoin('comments','replies.comment_id','=','comments.id')
                ->leftjoin('posts','comments.post_id','=','posts.id');

        $result = $result->orderBy("replies.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('status', function ($result) {
                if ($result->status == 'Active') {
                    return '<span class="badge badge-success">Active</span>';
                } elseif ($result->status == 'Pending') {
                    return '<span class="badge badge-danger">Pending</span>';
                } else {
                    return '<span class="badge badge-secondary">Unknown</span>';
                }
            })->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('success','Reply Deleted Successfully!');
    }

    public function changeStatus($id)
    {
        $result = Reply::find($id);

        if ($result->status == 'Pending') {
            $result->status = 'Active';
        } else {
            $result->status = 'Pending';
        }
        
        $result->save();

        return redirect()->back()->with('success','Reply Status Change Successfully!');
    }

}
