<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCategory;

class VideoGalleryController extends Controller
{
    public function index()
    {
        $video_categories = VideoCategory::with('video')->get();
        return view('front.video-gallery',compact('video_categories'));
    }
}
