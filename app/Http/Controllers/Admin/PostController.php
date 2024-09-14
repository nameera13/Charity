<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class PostController extends Controller
{
    
    public function __construct(Post $model)
    {
        $this->moduleName = "Posts";
        $this->model = $model;
        $this->moduleRoute = url('admin/post');
        $this->moduleView = "admin.main.post";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $posts = Post::get();
        return view('admin.main.post.index',compact('posts'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select([
            'posts.id', 
            'posts.photo', 
            'posts.title', 
            'posts.created_at', 
            'post_categories.name as category_name'
        ])->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id');

        $result = $result->orderBy("posts.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function create()
    {
        $post_categories = PostCategory::get();
        return view('admin.main.general.create',compact('post_categories'));
    }

    public function store(Request $request)
    {
        $data = new Post();

        if ($request->tags == null) {
            $tags = '';
        } else{
            $tags = implode(',', $request->tags);
        }

        $fileName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('admin/uploads/posts'),$fileName);
        $data->photo = $fileName;

        $data->post_category_id = $request->post_category_id;
        $data->title = $request->title;
        $data->slug = $request->slug;
        $data->short_description = $request->short_description;
        $data->description = $request->description;
        $data->tags = $tags;

        $data->save();

        return redirect($this->moduleRoute)->with('success','Post Created Successfully!');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $post_categories = PostCategory::get();
        $result = $this->model->find($id);
        $post_tags = explode(',',$result->tags);

        if ($result) {
            return view("admin.main.general.edit", compact("result","post_categories","post_tags"));
        }        
    }

    public function update(Request $request, $id)
    {
        $result = $this->model->find($id);

        if ($request->tags == null) {
            $tags = '';
        } else{
            $tags = implode(',', $request->tags);
        }

        if($request->photo != null){
            unlink(public_path('admin/uploads/posts/'.$result->photo));
            $fileName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('admin/uploads/posts'),$fileName);
            $result->photo = $fileName;

        }

        $result->post_category_id = $request->post_category_id;
        $result->title = $request->title;
        $result->slug = $request->slug;
        $result->short_description = $request->short_description;
        $result->description = $request->description;
        $result->tags = $tags;

        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Post Updated Successfully!');
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);
        unlink(public_path('admin/uploads/posts/'.$result->photo));
        $result->delete();

        return redirect()->back()->with('success','Post Deleted Successfully!');
    }

}

