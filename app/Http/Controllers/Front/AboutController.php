<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Counter;
use App\Models\Special;
use App\Models\Feature;
use App\Models\FeatureSectionItem;

class AboutController extends Controller
{
    public function index()
    {
        $counters = Counter::where('id',1)->first();
        $special = Special::where('id', 1)->first(); 
        $features = Feature::get();
        $feature_section_items = FeatureSectionItem::where('id', 1)->first();
        
        return view('front.about',compact('counters', 'special', 'features', 'feature_section_items'));
    }
}
