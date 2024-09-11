<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\FeatureSectionItem;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class FeatureController extends Controller
{
    
    public function __construct(Feature $model)
    {
        $this->moduleName = "Feature";
        $this->model = $model;
        $this->moduleRoute = url('admin/feature');
        $this->moduleView = "admin.main.feature";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $features = Feature::get();
        $feature_section_items = FeatureSectionItem::where('id', 1)->first();
        return view('admin.main.feature.index',compact('features','feature_section_items'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select(['id', 'icon', 'heading', 'created_at']);

        $result = $result->orderBy("features.created_at", "DESC");

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
        $data = new Feature();
        $data->icon = $request->icon;
        $data->heading = $request->heading;
        $data->text = $request->text;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Feature Created Successfully!');
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

        $result->icon = $request->icon;
        $result->heading = $request->heading;
        $result->text = $request->text;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Feature Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('Feature Deleted Successfully!');
    }

    public function featureSectionItem(Request $request)
    {
        $result = FeatureSectionItem::where('id', 1)->first();
        
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png|max:2048', 
            ]);
    
            if (!empty($result->photo) && file_exists(public_path('admin/uploads/feature-item/'.$result->photo))) {
                unlink(public_path('admin/uploads/feature-item/'.$result->photo));
            }
    
            $final_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('admin/uploads/feature-item'), $final_name);
            $result->photo = $final_name; 
        }    

        $result->status = $request->status;
        $result->update();

        return redirect($this->moduleRoute)->with('success','Feature Section Items are Updated Successfully!');

    }
}
