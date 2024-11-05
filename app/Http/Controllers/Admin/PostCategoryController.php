<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class PostCategoryController extends Controller
{
    
    public function __construct(PostCategory $model)
    {
        $this->moduleName = "Post Category";
        $this->model = $model;
        $this->moduleRoute = url('admin/post-category');
        $this->moduleView = "admin.main.post_category";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function index()
    {
        $post_category = PostCategory::get();
        return view('admin.main.post_category.index',compact('post_category'));
    }

    public function getDataTable(Request $request)
    {
        $result = $this->model->select(['id', 'name', 'slug', 'created_at']);

        $result = $result->orderBy("post_categories.created_at", "DESC");

        return DataTables::of($result)
        ->editColumn('created_at', function ($result) {
            return date("d-m-Y h:i A", strtotime($result->created_at));
        })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function create()
    {
        return view('admin.main.general.create');
    }

    public function store(Request $request)
    {
        $data = new PostCategory();
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->save();

        return redirect($this->moduleRoute)->with('success','Post Category Created Successfully!');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $result = $this->model->find($id);

        if ($result) {
            return view("admin.main.general.edit", compact("result"));
        }        
    }

    public function update(Request $request, $id)
    {
        $result = $this->model->find($id);

        $result->name = $request->name;
        $result->slug = $request->slug;
        $result->update();
        
        return redirect($this->moduleRoute)->with('success','Post Category Updated Successfully!');
    }

    public function destroy($id)
    {
        $posts = Post::where('post_category_id', $id)->get();
        foreach($posts as $post){
            unlink(public_path('uploads/posts/'.$post->photo));
        }

        Post::where('post_category_id', $id)->delete();
        PostCategory::where('id', $id)->delete();

        return redirect()->back()->with('success','Post Category Deleted Successfully!');
    }

}
