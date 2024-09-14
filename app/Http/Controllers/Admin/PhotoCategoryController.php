<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhotoCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class PhotoCategoryController extends Controller
{
    
    public function __construct(PhotoCategory $model)
    {
        $this->moduleName = "Photo Category";
        $this->model = $model;
        $this->moduleRoute = url('admin/photo-category');
        $this->moduleView = "admin.main.photo_category";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $photo_category = PhotoCategory::get();
        return view('admin.main.photo_category.index',compact('photo_category'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select(['id', 'name', 'created_at']);

        $result = $result->orderBy("photo_categories.created_at", "DESC");

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
        $data = new PhotoCategory();
        $data->name = $request->name;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Photo Category Created Successfully!');
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
        
        return redirect($this->moduleRoute)->with('success','Photo Category Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('success','Photo Category Deleted Successfully!');
    }

}
