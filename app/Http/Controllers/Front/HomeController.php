<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Slider;
use App\Models\Special;
use App\Models\Feature;
use App\Models\FeatureSectionItem;
use App\Models\Testimonial;
use App\Models\TestimonialSectionItem;


class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();
        $special = Special::where('id', 1)->first();
        $features = Feature::get();
        $feature_section_items = FeatureSectionItem::where('id', 1)->first();
        $testimonials = Testimonial::get();
        $testimonial_section_items = TestimonialSectionItem::where('id', 1)->first();

        return view('front.home',compact('sliders', 'special', 'features', 'feature_section_items', 'testimonials', 'testimonial_section_items'));
    }

    public function dashboard()
    {
        $users = User::get();
        return view('front.dashboard',compact('users'));
    }

}
