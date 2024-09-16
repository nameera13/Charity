<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
{
    
    public function __construct(Comment $model)
    {
        $this->moduleName = "Comments";
        $this->model = $model;
        $this->moduleRoute = url('admin/comments');

        $this->moduleView = "admin.main.comment";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        return view('admin.main.comment.index');

    }

    public function getDataTable(Request $request)
    {
        $result = Comment::select('comments.*', 'posts.title as post_name', 'posts.slug as slug')
                    ->leftjoin('posts','comments.post_id','=','posts.id');

        $result = $result->orderBy("comments.created_at", "DESC");

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

        return redirect()->back()->with('success','Comment Deleted Successfully!');
    }

    public function changeStatus($id)
    {
        $result = Comment::find($id);

        if ($result->status == 'Pending') {
            $result->status = 'Active';
        } else {
            $result->status = 'Pending';
        }
        
        $result->save();

        return redirect()->back()->with('success','Comment Status Change Successfully!');
    }

}
