<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{
    public function __construct(Setting $model)
    {
        $this->moduleName = "Setting";
        $this->model = $model;
        $this->moduleRoute = url('admin/setting');
        $this->moduleView = "admin.main.setting";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::find(1);
        return view('admin.main.setting.index',compact('setting'));
    }

    public function update(Request $request)
    {
        $Setting = Setting::where('id', 1)->first();

        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'image|mimes:jpg,jpeg,png'
            ]);

            if ($Setting->logo) {
                unlink(public_path('uploads/setting/' . $Setting->logo));
            }

            $fileName = 'logo_' . time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/setting'), $fileName);
            $Setting->logo = $fileName;
        }

        if ($request->hasFile('favicon')) {
            $request->validate([
                'favicon' => 'image|mimes:jpg,jpeg,png'
            ]);

            if ($Setting->favicon) {
                unlink(public_path('uploads/setting/' . $Setting->favicon));
            }

            $fileName = 'favicon_' . time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('uploads/setting'), $fileName);
            $Setting->favicon = $fileName;
        }

        if ($request->hasFile('banner')) {
            $request->validate([
                'banner' => 'image|mimes:jpg,jpeg,png'
            ]);

            if ($Setting->banner) {
                unlink(public_path('uploads/setting/' . $Setting->banner));
            }

            $fileName = 'banner_' . time() . '.' . $request->banner->extension();
            $request->banner->move(public_path('uploads/setting'), $fileName);
            $Setting->banner = $fileName;
        }

        $Setting->top_phone = $request->top_phone;
        $Setting->top_email = $request->top_email;

        $Setting->cta_heading = $request->cta_heading;
        $Setting->cta_text = $request->cta_text;
        $Setting->cta_button_text = $request->cta_button_text;
        $Setting->cta_button_url = $request->cta_button_url;        
        $Setting->cta_status = $request->cta_status;

        $Setting->footer_address = $request->footer_address;
        $Setting->footer_phone = $request->footer_phone;
        $Setting->footer_email = $request->footer_email;        
        $Setting->facebook = $request->facebook;
        $Setting->twitter = $request->twitter;
        $Setting->youtube = $request->youtube;
        $Setting->linkedin = $request->linkedin;
        $Setting->instagram = $request->instagram;
        $Setting->copyright = $request->copyright;

        $Setting->map = $request->map;
        
        $Setting->save();
        
        return redirect($this->moduleRoute)->with('success', 'Setting Updated Successfully!');
    }
  
}
