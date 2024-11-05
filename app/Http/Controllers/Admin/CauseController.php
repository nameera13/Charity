<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cause;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class CauseController extends Controller
{
    public function __construct(Cause $model)
    {
        $this->moduleName = "Cause";
        $this->model = $model;
        $this->moduleRoute = url('admin/cause');
        $this->moduleView = "admin.main.cause";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $causes = Cause::get();
        return view('admin.main.cause.index',compact('causes'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select('causes.*');

        $result = $result->orderBy("causes.created_at", "DESC");

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $causes = Cause::get();
        return view('admin.main.general.create',compact('causes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Cause();

        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->goal = $request->goal;
        $data->raised = 0;
        $data->short_description = $request->short_description;
        $data->description = $request->description;
        $data->is_featured = $request->is_featured;

        $fileName = time().'.'.$request->featured_photo->extension();
        $request->featured_photo->move(public_path('uploads/causes'),$fileName);
        $data->featured_photo = $fileName;

        $data->save();

        return redirect($this->moduleRoute)->with('success','Cause Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $causes = Cause::get();
        $result = $this->model->find($id);

        if ($result) {
            return view("admin.main.general.edit", compact("result","causes"));
        }        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->model->find($id);

        if($request->featured_photo != null){
            unlink(public_path('uploads/causes/'.$result->featured_photo));
            $fileName = time().'.'.$request->featured_photo->extension();
            $request->featured_photo->move(public_path('uploads/causes'),$fileName);
            $result->featured_photo = $fileName;

        }

        $result->name = $request->name;
        $result->slug = $request->slug;
        $result->goal = $request->goal;
        $result->short_description = $request->short_description;
        $result->description = $request->description;
        $result->is_featured = $request->is_featured;

        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Cause Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->model->find($id);
        unlink(public_path('uploads/causes/'.$result->featured_photo));
        $result->delete();

        return redirect()->back()->with('success','Cause Deleted Successfully!');
    }

    public function checkIsCauseNameUnique(Request $request)
    {
        $exists = Cause::where('name', $request->name)->exists(); 
        return response()->json(['exists' => $exists]);
    }
}
