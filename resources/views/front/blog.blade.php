@extends('front.layout.default')
@Section('title','Blog')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Blog</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Blog</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="blog pt_70">
    <div class="container">
        <div class="row">
            @foreach ($blogs as $key => $value)                
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="{{ asset('uploads/posts/'.$value->photo) }}" alt="" />
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
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</div> --}}

<div class="blog pt_70">
    <div class="container">
        <div class="row">
            @foreach ($blogs as $key => $value)
                <div class="col-lg-4 col-md-6 mb-4 d-flex">
                    <div class="card d-flex flex-column">
                        <img src="{{ asset('uploads/posts/'.$value->photo) }}" class="card-img-top img-fluid" alt="{{ $value->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2 text-truncate" style="height: 48px; overflow: hidden;">
                                <a href="{{ url('blog/'.$value->slug) }}" class="text-dark">{{ $value->title }}</a>
                            </h5>
                            <p class="card-text flex-grow-1">{{ $value->short_description }}</p>
                            <a href="{{ url('blog/'.$value->slug) }}" class="btn btn-success mt-auto align-self-start">
                                Read More <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-12">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</div>



@endsection