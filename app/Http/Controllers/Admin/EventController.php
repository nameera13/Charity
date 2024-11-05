<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class EventController extends Controller
{
    
    public function __construct(Event $model)
    {
        $this->moduleName = "Event";
        $this->model = $model;
        $this->moduleRoute = url('admin/event');
        $this->moduleView = "admin.main.event";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $events = Event::get();
        return view('admin.main.event.index',compact('events'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select('events.*');

        $result = $result->orderBy("events.created_at", "DESC");

        return DataTables::of($result)
            ->addColumn('photo', function($row) {
                return $row->photo;
            })
            ->editColumn('date', function($row) {
                return date("d-m-Y", strtotime($row->date)) . ' ' . date("h:i A", strtotime($row->time)); 
            })
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function create()
    {
        $events = Event::get();
        return view('admin.main.general.create',compact('events'));
    }

    public function store(Request $request)
    {
        $data = new Event();

        if ($request->total_seat != '') {
            
        }

        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->location = $request->location;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->price = $request->price;
        $data->total_seat = $request->total_seat;
        $data->map = $request->map;
        $data->short_description = $request->short_description;
        $data->description = $request->description;


        $fileName = time().'.'.$request->featured_photo->extension();
        $request->featured_photo->move(public_path('uploads/events'),$fileName);
        $data->featured_photo = $fileName;

        $data->save();

        return redirect($this->moduleRoute)->with('success','Event Created Successfully!');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $events = Event::get();
        $result = $this->model->find($id);

        if ($result) {
            return view("admin.main.general.edit", compact("result","events"));
        }        
    }

    public function update(Request $request, $id)
    {
        $result = $this->model->find($id);

        if($request->featured_photo != null){
            unlink(public_path('uploads/events/'.$result->featured_photo));
            $fileName = time().'.'.$request->featured_photo->extension();
            $request->featured_photo->move(public_path('uploads/events'),$fileName);
            $result->featured_photo = $fileName;

        }

        $result->name = $request->name;
        $result->slug = $request->slug;
        $result->location = $request->location;
        $result->date = $request->date;
        $result->time = $request->time;
        $result->price = $request->price;
        $result->total_seat = $request->total_seat;
        $result->map = $request->map;
        $result->short_description = $request->short_description;
        $result->description = $request->description;

        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Event Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        unlink(public_path('uploads/events/'.$result->featured_photo));
        $result->delete();

        return redirect()->back()->with('success','Event Deleted Successfully!');
    }

    public function checkIsEventNameUnique(Request $request)
    {
        $exists = Event::where('name', $request->name)->exists(); 
        return response()->json(['exists' => $exists]);
    }

}
