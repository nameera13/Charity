@extends('front.layout.default')
@section('title','Video Gallery')
@section('front')

<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Video Gallery</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Video Gallery</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-content pt_40 pb_45">
    <div class="container">
        <div class="row">

            @foreach ($video_categories as $video_category)                
                <div class="col-md-12 mb_15">
                    <h2 class="video-gallery-heading pt_30">{{ $video_category->name }}</h2>
                </div>

                @foreach ($video_category->video as $value)                
                    <div class="col-md-6 col-lg-3">
                        <div class="video-gallery-item mb_25">
                            <div class="video-gallery-item-bg"></div>
                            <a class="video-button" href="http://www.youtube.com/watch?v={{ $value->youtube_video_id }}">
                                <img src="http://img.youtube.com/vi/{{ $value->youtube_video_id }}/0.jpg">
                                <div class="plus-icon"><i class="fas fa-search-plus"></i></div>
                            </a>
                        </div>
                    </div>
                @endforeach

            @endforeach

        </div>
    </div>
</div>

@endsection