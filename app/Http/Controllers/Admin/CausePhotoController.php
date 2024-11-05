<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cause;
use App\Models\CausePhoto;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class CausePhotoController extends Controller
{
    public function __construct(CausePhoto $model)
    {
        $this->moduleName = "Cause Photo";
        $this->model = $model;
        $this->moduleRoute = url('admin/cause-photo');
        $this->moduleView = "admin.main.cause";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

   
    public function photo(string $id)
    {
        $cause = Cause::where('id', $id)->first();
        return view('admin.main.cause.cause_photo',compact('cause'));
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

        $data = new CausePhoto();
        $data->cause_id = $request->cause_id;

        $fileName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('uploads/cause-photo'),$fileName);
        $data->photo = $fileName;

        $data->save();

        return redirect()->back()->with('success','Cause Photo Created Successfully!');
    }

    public function getDataTable(Request $request)
    {
        $causeId = $request->input('cause_id');
        $result = $this->model->where('cause_id', $causeId)->select('cause_photos.*');

        $result = $result->orderBy("cause_photos.created_at", "DESC");

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
        unlink(public_path('uploads/cause-photo/'.$result->photo));
        $result->delete();

        return redirect()->back()->with('success','Cause Photo Deleted Successfully!');
    }
}
