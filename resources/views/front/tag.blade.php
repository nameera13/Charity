@extends('front.layout.default')
@Section('title','Blog')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Tag: {{ $tag_name }}</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Tag</li>
                        <li class="breadcrumb-item active">{{ $tag_name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blog pt_70">
    <div class="container">
        <div class="row">
            @foreach ($posts as $key => $value)                
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="{{ asset('admin/uploads/posts/'.$value->photo) }}" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="{{ url('blog/'.$value->slug) }}">{{ $value->title }}</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    {{ $value->short_description }}
                                </p>
                            </div>
                            <div class="button-style-2 mt_20">
                                <a href="{{ url('blog/'.$value->slug) }}">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-12">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection