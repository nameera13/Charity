<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Post::with('post_category')->paginate(15);
        return view('front.blog',compact('blogs'));
    }

    public function detail($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $latest_posts = Post::orderBy('id','desc')->limit(5)->get();
        $post_categories = PostCategory::orderBy('name','asc')->get();
        $post_date = Carbon::parse($post->created_at)->format('j F, Y');
        $post_tags = explode(',', $post->tags);
        $tags = Post::pluck('tags')->flatMap(function($item){
            return explode(',', $item);
        })->unique()->values();
        return view('front.blog_details',compact('post', 'latest_posts', 'post_categories', 'post_date', 'post_tags', 'tags'));
    }

    public function category($slug)
    {
        $post_category = PostCategory::where('slug',$slug)->first();
        $posts = Post::where('post_category_id',$post_category->id)->paginate(15);
        return view('front.category',compact('post_category', 'posts'));
    }

    public function tag($name)
    {
        // $posts = Post::where('tags','like','%' . $name .'%')->paginate(15);
        $posts = Post::whereRaw('FIND_IN_SET(?,tags)', [$name])->paginate(15);
        $tag_name = $name;
        return view('front.tag',compact('posts', 'tag_name'));
    }
}
