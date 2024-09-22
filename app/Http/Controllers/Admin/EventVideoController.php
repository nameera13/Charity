<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventVideo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class EventVideoController extends Controller
{
    public function __construct(EventVideo $model)
    {
        $this->moduleName = "Event Video";
        $this->model = $model;
        $this->moduleRoute = url('admin/event-video');
        $this->moduleView = "admin.main.event";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

   
    public function video(string $id)
    {
        $event = Event::where('id', $id)->first();
        return view('admin.main.event.event_video',compact('event'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'youtube_video_id' => 'required',
        ]);

        $data = new EventVideo();
        $data->event_id = $request->event_id;
        $data->youtube_video_id = $request->youtube_video_id;
        $data->save();

        return redirect()->back()->with('success','Event Video Created Successfully!');
    }

    public function getDataTable(Request $request)
    {
        $eventId = $request->input('event_id'); 
        $result = $this->model->where('event_id', $eventId)->select('event_videos.*');
    
        $result = $result->orderBy("event_videos.created_at", "DESC");

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

        return redirect()->back()->with('success','Event Video Deleted Successfully!');
    }
}
