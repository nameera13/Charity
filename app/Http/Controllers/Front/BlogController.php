<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Comment;
use App\Models\Reply;
use Carbon\Carbon;
use App\Mail\Websiteemail;
use App\Models\Admin;

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

        $total_comments = Comment::where('status', 'Active')->where('post_id', $post->id)->count();
        $comments = Comment::orderBy('id','asc')->where('status', 'Active')->where('post_id', $post->id)->get();

        return view('front.blog_details',compact('post', 'latest_posts', 'post_categories', 'post_date', 'post_tags', 'tags', 'total_comments', 'comments'));
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

    public function comment(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required'
        ]);

        $comment = new Comment();
        $comment->post_id = $request->post_id; 
        $comment->comment = $request->comment; 
        $comment->name = $request->name; 
        $comment->email = $request->email; 
        $comment->status = 'Pending'; 
        $comment->save();

        // Send Email to Admin
        $subject = 'New Comment Submitted';
        $message = 'A new comment has been submitted on your website. Please login to your admin panel to approve it.<br>';
        $message .= '<a href="'.url('admin/comments').'"> Click Here </a>';

        $admin_email = Admin::where('id',1)->first()->email;
        \Mail::to($admin_email)->send(new Websiteemail($subject,$message));
        
        return redirect()->back()->with('success','Comment Submitted Successfully!');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'reply' => 'required'
        ]);

        $reply = new Reply();
        $reply->comment_id = $request->comment_id; 
        $reply->reply = $request->reply; 
        $reply->name = $request->name; 
        $reply->email = $request->email; 
        $reply->user_type = 'Visitor'; 
        $reply->status = 'Pending'; 
        $reply->save();

        // Send Email to Admin
        $subject = 'New Reply Submitted';
        $message = 'A new reply has been submitted on your blog post. Please login to your admin panel to approve it.<br>';
        $message .= '<a href="'.url('admin/reply').'"> Click Here </a>';

        $admin_email = Admin::where('id',1)->first()->email;
        \Mail::to($admin_email)->send(new Websiteemail($subject,$message));
        
        return redirect()->back()->with('success','Reply Submitted Successfully!');
    }
}
