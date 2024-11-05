<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomePageItem;
use Illuminate\Support\Facades\View;

class HomePageItemController extends Controller
{
    public function __construct(HomePageItem $model)
    {
        $this->moduleName = "Home Page Item";
        $this->model = $model;
        $this->moduleRoute = url('admin/home-page-item');
        $this->moduleView = "admin.main.home_page_item";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $home_page_items = HomePageItem::where('id',1)->first();
        return view('admin.main.home_page_item.index', compact('home_page_items'));
    }


    public function update(Request $request)
    {
        $home_page_item = HomePageItem::where('id', 1)->first();

        if ($request->hasFile('feature_background')) {
            $request->validate([
                'feature_background' => 'image|mimes:jpg,jpeg,png'
            ]);

            if ($home_page_item->feature_background) {
                unlink(public_path('uploads/home-page-item/' . $home_page_item->feature_background));
            }

            $fileName = 'feature_background_' . time() . '.' . $request->feature_background->extension();
            $request->feature_background->move(public_path('uploads/home-page-item'), $fileName);
            $home_page_item->feature_background = $fileName;
        }

        if ($request->hasFile('testimonial_background')) {
            $request->validate([
                'testimonial_background' => 'image|mimes:jpg,jpeg,png'
            ]);

            if ($home_page_item->testimonial_background) {
                unlink(public_path('uploads/home-page-item/' . $home_page_item->testimonial_background));
            }

            $fileName = 'testimonial_background_' . time() . '.' . $request->testimonial_background->extension();
            $request->testimonial_background->move(public_path('uploads/home-page-item'), $fileName);
            $home_page_item->testimonial_background = $fileName;
        }

        $home_page_item->cause_heading = $request->cause_heading;
        $home_page_item->cause_subheading = $request->cause_subheading;
        $home_page_item->cause_status = $request->cause_status;
        
        $home_page_item->feature_status = $request->feature_status;

        $home_page_item->event_heading = $request->event_heading;
        $home_page_item->event_subheading = $request->event_subheading;
        $home_page_item->event_status = $request->event_status;
        
        $home_page_item->testimonial_heading = $request->testimonial_heading;
        $home_page_item->testimonial_status = $request->testimonial_status;

        $home_page_item->blog_heading = $request->blog_heading;
        $home_page_item->blog_subheading = $request->blog_subheading;
        $home_page_item->blog_status = $request->blog_status;
        
        $home_page_item->save();
        
        return redirect($this->moduleRoute)->with('success', 'Home Page Item Updated Successfully!');
    }

}
