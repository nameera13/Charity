<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class VideoCategoryController extends Controller
{
    
    public function __construct(VideoCategory $model)
    {
        $this->moduleName = "Video Category";
        $this->model = $model;
        $this->moduleRoute = url('admin/video-category');
        $this->moduleView = "admin.main.video_category";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $video_category = VideoCategory::get();
        return view('admin.main.video_category.index',compact('video_category'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select(['id', 'name', 'created_at']);

        $result = $result->orderBy("video_categories.created_at", "DESC");

        return DataTables::of($result)
        ->editColumn('created_at', function ($result) {
            return date("d-m-Y h:i A", strtotime($result->created_at));
        })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function create()
    {
        return view('admin.main.general.create');
    }

    public function store(Request $request)
    {
        $data = new VideoCategory();
        $data->name = $request->name;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Video Category Created Successfully!');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $result = $this->model->find($id);

        if ($result) {
            return view("admin.main.general.edit", compact("result"));
        }        
    }

    public function update(Request $request, $id)
    {
        $result = $this->model->find($id);

        $result->name = $request->name;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Video Category Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('success','Video Category Deleted Successfully!');
    }

}
