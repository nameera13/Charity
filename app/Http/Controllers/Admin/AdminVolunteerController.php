<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Volunteer;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class AdminVolunteerController extends Controller
{
    
    public function __construct(Volunteer $model)
    {
        $this->moduleName = "Volunteer";
        $this->model = $model;
        $this->moduleRoute = url('admin/volunteer');
        $this->moduleView = "admin.main.volunteer";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $volunteers = Volunteer::get();
        return view('admin.main.volunteer.index',compact('volunteers'));
    }

    public function getDataTable(Request $request)
    {
        // $result = $this->model->select('*');
        $result = $this->model->select(['id', 'photo', 'name', 'profession', 'created_at']);

        $result = $result->orderBy("volunteers.created_at", "DESC");

        return DataTables::of($result)
            ->addColumn('photo', function($row) {
                return $row->photo;
            })
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
        $data = new Volunteer();
        $data->name = $request->name;
        $data->profession = $request->profession;
        $data->address = $request->address;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->website = $request->website;
        $data->facebook = $request->facebook;
        $data->twitter = $request->twitter;
        $data->linkedin = $request->linkedin;
        $data->instagram = $request->instagram;
        $data->detail = $request->detail;
        $fileName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('admin/uploads/volunteers'),$fileName);
        $data->photo = $fileName;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Volunteer Created Successfully!');
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

        if($request->photo != null){
            unlink(public_path('admin/uploads/volunteers/'.$result->photo));
            $fileName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('admin/uploads/volunteers'),$fileName);
            $result->photo = $fileName;

        }

        $result->name = $request->name;
        $result->profession = $request->profession;
        $result->address = $request->address;
        $result->email = $request->email;
        $result->phone = $request->phone;
        $result->website = $request->website;
        $result->facebook = $request->facebook;
        $result->twitter = $request->twitter;
        $result->linkedin = $request->linkedin;
        $result->instagram = $request->instagram;
        $result->detail = $request->detail;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Volunteer Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        unlink(public_path('admin/uploads/volunteers/'.$result->photo));
        $result->delete();

        return redirect()->back()->with('Volunteer Deleted Successfully!');
    }


}