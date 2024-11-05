@extends('front.layout.default')
@Section('title','Event')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Events</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Events</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="event pt_70">
    <div class="container">
        <div class="row">
            @foreach ($events as $value)                
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="{{ asset('uploads/events/'.$value->featured_photo) }}" alt="">
                        </div>
                        <div class="text">
                            <h2 class="text-truncate">
                                {{ $value->name }}
                            </h2>
                            <div class="date-time">
                                <i class="fas fa-calendar-alt"></i> 
                                @php
                                    $date = \Carbon\Carbon::parse($value->date)->format('j M, Y');
                                    $time = \Carbon\Carbon::parse($value->time)->format('h:i A');
                                @endphp
                                {{ $date }},{{ $time }}
                            </div>
                            <div class="short-des" style="height: 5em; overflow: hidden;">
                                <p style="margin: 0; line-height: 1.5;">
                                    {!! $value->short_description !!}
                                </p>
                            </div>
                            <div class="button-style-2">
                                <a href="{{ url('events/'.$value->slug) }}">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
