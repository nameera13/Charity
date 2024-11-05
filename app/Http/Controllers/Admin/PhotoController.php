<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\PhotoCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class PhotoController extends Controller
{
    
    public function __construct(Photo $model)
    {
        $this->moduleName = "Photo";
        $this->model = $model;
        $this->moduleRoute = url('admin/photo');
        $this->moduleView = "admin.main.photo";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $photos = Photo::get();
        return view('admin.main.photo.index',compact('photos'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select([
            'photos.id', 
            'photos.photo', 
            'photos.created_at', 
            'photo_categories.name as category_name'
        ])->leftJoin('photo_categories', 'photos.photo_category_id', '=', 'photo_categories.id');

        $result = $result->orderBy("photos.created_at", "DESC");

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
        $photo_categories = PhotoCategory::get();
        return view('admin.main.general.create',compact('photo_categories'));
    }

    public function store(Request $request)
    {
        $data = new Photo();
        $data->photo_category_id = $request->photo_category_id;
        $fileName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('uploads/photos'),$fileName);
        $data->photo = $fileName;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Photo Created Successfully!');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $photo_categories = PhotoCategory::get();
        $result = $this->model->find($id);

        if ($result) {
            return view("admin.main.general.edit", compact("result","photo_categories"));
        }        
    }

    public function update(Request $request, $id)
    {
        $result = $this->model->find($id);

        if($request->photo != null){
            unlink(public_path('uploads/photos/'.$result->photo));
            $fileName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/photos'),$fileName);
            $result->photo = $fileName;

        }

        $result->photo_category_id = $request->photo_category_id;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Photo Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        unlink(public_path('uploads/photos/'.$result->photo));
        $result->delete();

        return redirect()->back()->with('success','Photo Deleted Successfully!');
    }

}
