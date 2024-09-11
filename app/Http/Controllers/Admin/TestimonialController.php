<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\TestimonialSectionItem;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class TestimonialController extends Controller
{
    
    public function __construct(Testimonial $model)
    {
        $this->moduleName = "Testimonial";
        $this->model = $model;
        $this->moduleRoute = url('admin/testimonial');
        $this->moduleView = "admin.main.testimonial";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $testimonials = Testimonial::get();
        $testimonial_section_items = TestimonialSectionItem::where('id', 1)->first();
        return view('admin.main.testimonial.index',compact('testimonials','testimonial_section_items'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select(['id', 'photo', 'name', 'designation', 'comment', 'created_at']);

        $result = $result->orderBy("testimonials.created_at", "DESC");

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
        $data = new Testimonial();
        $data->name = $request->name;
        $data->designation = $request->designation;
        $data->comment = $request->comment;
        $fileName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('admin/uploads/testimonials'),$fileName);
        $data->photo = $fileName;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Testimonial Created Successfully!');
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
            unlink(public_path('admin/uploads/testimonials/'.$result->photo));
            $fileName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('admin/uploads/testimonials'),$fileName);
            $result->photo = $fileName;

        }

        $result->name = $request->name;
        $result->designation = $request->designation;
        $result->comment = $request->comment;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Testimonial Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        unlink(public_path('admin/uploads/testimonials/'.$result->photo));
        $result->delete();

        return redirect()->back()->with('Testimonials Deleted Successfully!');
    }

    public function testimonialSectionItem(Request $request)
    {
        $result = TestimonialSectionItem::where('id', 1)->first();
        
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png|max:2048', 
            ]);
    
            if (!empty($result->photo) && file_exists(public_path('admin/uploads/testimonial-item/'.$result->photo))) {
                unlink(public_path('admin/uploads/testimonial-item/'.$result->photo));
            }
    
            $final_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('admin/uploads/testimonial-item'), $final_name);
            $result->photo = $final_name; 
        }    

        $result->heading = $request->heading;
        $result->status = $request->status;
        $result->update();

        return redirect($this->moduleRoute)->with('success','Testimonial Section Items are Updated Successfully!');

    }
}
