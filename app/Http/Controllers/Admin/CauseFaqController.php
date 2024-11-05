<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cause;
use App\Models\CauseFaq;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class CauseFaqController extends Controller
{
    public function __construct(CauseFaq $model)
    {
        $this->moduleName = "Cause Faq";
        $this->model = $model;
        $this->moduleRoute = url('admin/cause-faq');
        $this->moduleView = "admin.main.cause";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function faq(string $id)
    {
        $cause = Cause::where('id', $id)->first();
        return view('admin.main.cause.cause_faq',compact('cause'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $data = new CauseFaq();
        $data->cause_id = $request->cause_id;
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->save();

        return redirect()->back()->with('success','Cause FAQ Created Successfully!');
    }

    public function getDataTable(Request $request)
    {
        $causeId = $request->input('cause_id'); 
        $result = $this->model->where('cause_id', $causeId)->select('cause_faqs.*');
    
        $result = $result->orderBy("cause_faqs.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function edit($id)
    {
        $faq = CauseFaq::find($id);
        return response()->json($faq);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_question' => 'required',
            'edit_answer' => 'required',
        ]);
        
        $result = $this->model->find($id);
        $result->question = $request->edit_question;
        $result->answer = $request->edit_answer;
        $result->update();
        
        return redirect()->back()->with('success','Cause FAQ Updated Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->model->find($id);
        $result->delete();

        return redirect()->back()->with('success','Cause Faq Deleted Successfully!');
    }
}
