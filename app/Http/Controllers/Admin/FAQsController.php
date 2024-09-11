<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class FAQsController extends Controller
{
    
    public function __construct(FAQ $model)
    {
        $this->moduleName = "FAQs";
        $this->model = $model;
        $this->moduleRoute = url('admin/faqs');
        $this->moduleView = "admin.main.faq";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $faqs = FAQ::get();
        return view('admin.main.faq.index',compact('faqs'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select(['id', 'question', 'created_at']);

        $result = $result->orderBy("faqs.created_at", "DESC");

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
        $data = new FAQ();
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->save();

        return redirect($this->moduleRoute)->with('success','FAQ Created Successfully!');
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

        $result->question = $request->question;
        $result->answer = $request->answer;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','FAQ Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('FAQ Deleted Successfully!');
    }

}
