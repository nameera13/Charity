<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class VideoController extends Controller
{
    
    public function __construct(Video $model)
    {
        $this->moduleName = "Video";
        $this->model = $model;
        $this->moduleRoute = url('admin/video');
        $this->moduleView = "admin.main.video";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $videos = Video::get();
        return view('admin.main.video.index',compact('videos'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select([
            'videos.id', 
            'videos.youtube_video_id', 
            'videos.created_at', 
            'video_categories.name as category_name'
        ])->leftJoin('video_categories', 'videos.video_category_id', '=', 'video_categories.id');

        $result = $result->orderBy("videos.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function create()
    {
        $video_categories = VideoCategory::get();
        return view('admin.main.general.create',compact('video_categories'));
    }

    public function store(Request $request)
    {
        $data = new Video();
        $data->video_category_id = $request->video_category_id;
        $data->youtube_video_id = $request->youtube_video_id;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Video Created Successfully!');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $video_categories = VideoCategory::get();
        $result = $this->model->find($id);

        if ($result) {
            return view("admin.main.general.edit", compact("result","video_categories"));
        }        
    }

    public function update(Request $request, $id)
    {
        $result = $this->model->find($id);

        $result->video_category_id = $request->video_category_id;
        $result->youtube_video_id = $request->youtube_video_id;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Video Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('success','Video Deleted Successfully!');
    }

}
