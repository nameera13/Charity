<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventPhoto;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class EventPhotoController extends Controller
{
    public function __construct(EventPhoto $model)
    {
        $this->moduleName = "Event Photo";
        $this->model = $model;
        $this->moduleRoute = url('admin/event-photo');
        $this->moduleView = "admin.main.event";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

   
    public function photo(string $id)
    {
        $event = Event::where('id', $id)->first();
        return view('admin.main.event.event_photo',compact('event'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|mimes:jpeg,jpg,png|max:2048',
        ], [
            'photo.required' => 'Please upload an image.',
            'photo.mimes' => 'Only JPG and PNG formats are allowed.',
            'photo.max' => 'The image size should not exceed 2MB.',
        ]);

        $data = new EventPhoto();
        $data->event_id = $request->event_id;

        $fileName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('admin/uploads/event-photo'),$fileName);
        $data->photo = $fileName;

        $data->save();

        return redirect()->back()->with('success','Event Photo Created Successfully!');
    }

    public function getDataTable(Request $request)
    {
        $eventId = $request->input('event_id');
        $result = $this->model->where('event_id', $eventId)->select('event_photos.*');

        $result = $result->orderBy("event_photos.created_at", "DESC");

        return DataTables::of($result)
            ->addColumn('photo', function($row) {
                return $row->photo;
            })
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
        unlink(public_path('admin/uploads/event-photo/'.$result->photo));
        $result->delete();

        return redirect()->back()->with('success','Event Photo Deleted Successfully!');
    }
}
