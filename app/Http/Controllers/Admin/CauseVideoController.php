<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cause;
use App\Models\CauseVideo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class CauseVideoController extends Controller
{
    public function __construct(CauseVideo $model)
    {
        $this->moduleName = "Cause Video";
        $this->model = $model;
        $this->moduleRoute = url('admin/cause-video');
        $this->moduleView = "admin.main.cause";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

   
    public function video(string $id)
    {
        $cause = Cause::where('id', $id)->first();
        return view('admin.main.cause.cause_video',compact('cause'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'youtube_video_id' => 'required',
        ]);

        $data = new CauseVideo();
        $data->cause_id = $request->cause_id;
        $data->youtube_video_id = $request->youtube_video_id;
        $data->save();

        return redirect()->back()->with('success','Cause Video Created Successfully!');
    }

    public function getDataTable(Request $request)
    {
        $causeId = $request->input('cause_id'); 
        $result = $this->model->where('cause_id', $causeId)->select('cause_videos.*');
    
        $result = $result->orderBy("cause_videos.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('success','Cause Video Deleted Successfully!');
    }
}
