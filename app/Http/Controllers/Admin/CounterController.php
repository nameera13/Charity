<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Counter;
use Illuminate\Support\Facades\View;

class CounterController extends Controller
{
    public function __construct(Counter $model)
    {
        $this->moduleName = "Counter";
        $this->model = $model;
        $this->moduleRoute = url('admin/counter');
        $this->moduleView = "admin.main.counter";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function edit()
    {
        $result = $this->model->find(1);

        return view("admin.main.counter.edit", compact("result"));
         
    }

    public function update(Request $request) 
    {
        $result = $this->model->find(1);  

        $result->counter1_number = $request->counter1_number;
        $result->counter1_name = $request->counter1_name;
        $result->counter2_number = $request->counter2_number;
        $result->counter2_name = $request->counter2_name;
        $result->counter3_number = $request->counter3_number;
        $result->counter3_name = $request->counter3_name;
        $result->counter4_number = $request->counter4_number;
        $result->counter4_name = $request->counter4_name;
        $result->status = $request->status;
        $result->update();

        return redirect($this->moduleRoute)->with('success','Counter Updated Successfully!');

    }
}
