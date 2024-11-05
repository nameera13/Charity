@extends('front.layout.default')
@section('title','Blog Details')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $post->title }}</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('blog') }}">Blog</a></li>
                        <li class="breadcrumb-item active">{{ $post->slug }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="post pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="left-item">
                    <div class="main-photo">
                        <img src="{{ asset('uploads/posts/'.$post->photo) }}" alt="">
                    </div>
                    <div class="sub">
                        <ul>
                            <li><i class="fas fa-calendar-alt"></i> On: {{ $post_date }}</li>
                            <li><i class="fas fa-th-large"></i> Category: 
                                <a href="{{ url('category/'.$post->post_category->slug) }}">{{ $post->post_category ? $post->post_category->name : 'Uncategorized' }}</a>
                            </li>                                                    
                        </ul>
                    </div>
                    <div class="description">
                        <p>
                            {!! $post->description !!}
                        </p>
                    </div>
                    <div class="tags" style="margin-top:20px; margin-bottom:15px;">
                        <h5>Tags</h5>
                        @for ($i = 0; $i < count($post_tags); $i++)
                            <a href="{{ url('tag/'.$post_tags[$i]) }}" style="background:#1455c6; padding:5px 10px; color:#fff; border-radius:6px; display:inline-block;">
                                {{ $post_tags[$i] }}
                            </a>
                        @endfor
                    </div>                    
                    <div class="comment">

                        <h2>{{ $total_comments }} Comments</h2>

                        @foreach ($comments as $value)
                            <div class="comment-section">
                                <div class="comment-box d-flex justify-content-start">
                                    <div class="left">
                                        @php
                                            $default = "";
                                            $size = 200;
                                            $gravatar_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($value->email))) . "?d=" . urlencode($default) . "&s=" . $size;
                                        @endphp
                                        <img src="{{ $gravatar_url }}" alt="">
                                    </div>
                                    <div class="right">
                                        <div class="name">{{ $value->name }}</div>
                                        <div class="date">
                                            @php
                                                $date = \Carbon\Carbon::parse($value->created_at)->format('j F, Y');
                                            @endphp
                                            {{ $date }}
                                        </div>
                                        <div class="text">
                                            {{ $value->comment }}
                                        </div>
                                        <div class="reply">
                                            <a href="" data-bs-toggle="modal" data-bs-target="#reply_modal{{ $loop->iteration }}"><i class="fas fa-reply"></i> Reply</a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="modal fade" id="reply_modal{{ $loop->iteration }}" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="replyModalLabel">Give a Reply</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                            </div>
                                            <form action="{{ url('reply') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="comment_id" value="{{ $value->id }}">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                                        @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <textarea class="form-control h_100" name="reply" id="reply" cols="30" rows="10"></textarea>
                                                        @error('reply')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $replies = App\Models\Reply::where('comment_id', $value->id)->where('status','Active')->get();
                                @endphp
                                @foreach ($replies as $value)                                 
                                    @php
                                        if ($value->user_type == 'Admin') {                                        
                                            $name = Auth::guard('admin')->user()->name;
                                            $email = Auth::guard('admin')->user()->email;
                                        } else {
                                            $name = $value->name;
                                            $email = $value->email;
                                        }
                                        
                                    @endphp  
                                    <div class="comment-box reply-box d-flex justify-content-start">
                                        <div class="left">
                                            @php
                                                $default = "";
                                                $size = 200;
                                                $gravatar_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
                                            @endphp
                                            <img src="{{ $gravatar_url }}" alt="">
                                        </div>
                                        <div class="right">
                                            <div class="name">
                                                {{ $name }}
                                                @if ($value->user_type == 'Admin')
                                                    <span class="badge bg-primary">Admin</span>                                                    
                                                @endif
                                            </div>
                                            <div class="date">
                                                @php
                                                    $date = \Carbon\Carbon::parse($value->created_at)->format('j F, Y');
                                                @endphp
                                                {{ $date }}
                                            </div>
                                            <div class="text">
                                                {{ $value->reply }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="mt_40"></div>

                        <h2>Leave Your Comment</h2>
                        <form action="{{ url('comment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input name="name" type="text" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input name="email" type="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" rows="3" placeholder="Comment">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit <i class="fas fa-long-arrow-alt-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-12">
                <div class="right-item">
                    <h2>Latest Posts</h2>
                    <ul>
                        @foreach ($latest_posts as $value)
                            <li><a href="{{ url('blog/'.$value->slug) }}"><i class="fas fa-angle-right"></i> {{ $value->title }} </a></li>
                        @endforeach
                    </ul>

                    <h2 class="mt_40">Categories</h2>
                    <ul>
                        @foreach ($post_categories as $value)
                        <li><a href="{{ url('category/'.$value->slug) }}"><i class="fas fa-angle-right"></i> {{ $value->name }} </a></li>
                        @endforeach
                    </ul>

                    <h2 class="mt_40">Tags</h2>
                    <ul class="tag">
                        @for ($i = 0; $i < count($tags); $i++)
                            <li><a href="{{ url('tag',$tags[$i]) }}">{{ $tags[$i] }}</a></li>
                        @endfor
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection