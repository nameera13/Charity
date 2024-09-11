<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Special;
use Illuminate\Support\Facades\View;

class SpecialController extends Controller
{
    public function __construct(Special $model)
    {
        $this->moduleName = "Special";
        $this->model = $model;
        $this->moduleRoute = url('admin/special');
        $this->moduleView = "admin.main.special";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function edit()
    {
        $result = $this->model->find(1);

        return view("admin.main.special.edit", compact("result"));
         
    }

    public function update(Request $request) 
    {
        $request->validate([
            'heading' => 'required',
            'text' => 'required',
            'video' => 'required',
        ]);

        $result = $this->model->find(1);
        
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png|max:2048', 
            ]);
    
            if (!empty($result->photo) && file_exists(public_path('admin/uploads/specials/'.$result->photo))) {
                unlink(public_path('admin/uploads/specials/'.$result->photo));
            }
    
            $final_name = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('admin/uploads/specials'), $final_name);
            $result->photo = $final_name; 
        }    

        $result->heading = $request->heading;
        $result->sub_heading = $request->sub_heading;
        $result->text = $request->text;
        $result->btn_text = $request->btn_text;
        $result->btn_link = $request->btn_link;
        $result->video = $request->video;
        $result->status = $request->status;
        $result->update();

        return redirect($this->moduleRoute)->with('success','Special Updated Successfully!');

    }
}
