<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhotoCategory;

class PhotoGalleryController extends Controller
{

    public function index()
    {
        $photo_categories = PhotoCategory::with('photo')->get();
        return view('front.photo-gallery',compact('photo_categories'));
    }

}
