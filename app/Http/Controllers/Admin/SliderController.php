<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class SliderController extends Controller
{
    
    public function __construct(Slider $model)
    {
        $this->moduleName = "Slider";
        $this->model = $model;
        $this->moduleRoute = url('admin/slider');
        $this->moduleView = "admin.main.slider";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $sliders = Slider::get();
        return view('admin.main.slider.index',compact('sliders'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select(['id', 'photo', 'heading', 'created_at']);

        $result = $result->orderBy("sliders.created_at", "DESC");

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
        $data = new Slider();
        $data->heading = $request->heading;
        $data->text = $request->text;
        $data->btn_text = $request->btn_text;
        $data->btn_link = $request->btn_link;
        $fileName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('uploads/sliders'),$fileName);
        $data->photo = $fileName;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Slider Created Successfully!');
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
            unlink(public_path('uploads/sliders/'.$result->photo));
            $fileName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/sliders'),$fileName);
            $result->photo = $fileName;

        }

        $result->heading = $request->heading;
        $result->text = $request->text;
        $result->btn_text = $request->btn_text;
        $result->btn_link = $request->btn_link;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Slider Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        unlink(public_path('uploads/sliders/'.$result->photo));
        $result->delete();

        return redirect()->back()->with('success','Slider Deleted Successfully!');
    }
}
