@extends('front.layout.default')
@section('title','Home')
@section('front')

    @include('front.include.slider')

    @if($special->status == 'show')        
        <div class="special pt_70 pb_70">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="left-side">
                                        <div class="inner">
                                            <h2>{{ $special->sub_heading }}</h2>
                                            <h3>{{ $special->heading }}</h3>
                                            <p>
                                                {!! $special->text !!}    
                                            </p>
                                            <div class="button-style-1 mt_20">
                                                <a href="{{ $special->btn_link }}">{{ $special->btn_text }} <i class="fas fa-long-arrow-alt-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="right-side" style="background-image: url({{ asset('uploads/specials/'.$special->photo) }});">
                                        <a class="video-button" href="{{ $special->video }}" target="_blank" rel="noopener noreferrer">
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($home_page_item->cause_status == 'show')
    <div class="cause pt_70">
        <div class="container">
            @if ($home_page_item->cause_heading != '' || $home_page_item->cause_subheading != '')                
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>{{ $home_page_item->cause_heading }}</h2>
                        <p>
                            {{ $home_page_item->cause_subheading }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                @foreach ($featured_causes as $value)                    
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="{{ asset('uploads/causes/'.$value->featured_photo) }}" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="{{ url('causes/'.$value->slug) }}">{{ $value->name }}</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    {!! $value->short_description !!}
                                </p>
                            </div>
                            @php
                                $percentage = ($value->raised / $value->goal) * 100;
                                $percentage = ceil($percentage);
                            @endphp
                            <div class="progress mb_10">
                                <div class="progress-bar w-0" role="progressbar" aria-label="Example with label"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100" 
                                    style="animation: progressAnimation{{ $loop->iteration }} 2s linear forwards;"></div>
                                <style>
                                    @keyframes progressAnimation{{ $loop->iteration }} {
                                        from {
                                            width: 0;
                                        }to {
                                            width: {{ $percentage }}%;
                                        }
                                    }
                                </style>
                            </div>
                            <div class="lbl mb_20">
                                <div class="goal">Goal: ₹{{ $value->goal }}</div>
                                <div class="raised">Raised: ₹{{ $value->raised }}</div>
                            </div>
                            <div class="button-style-2">
                                <a href="{{ url('causes/'.$value->slug) }}">Donate Now <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif


    @if($home_page_item->feature_status == 'show')
    <div class="why-choose pt_70" style="background-image: url({{ asset('uploads/home-page-item/'.$home_page_item->feature_background) }})">
        <div class="container">
            <div class="row">
                @foreach ($features as $key => $value)                    
                <div class="col-md-4">
                    <div class="inner pb_70">
                        <div class="icon">
                            <i class="{{ $value->icon }}"></i>
                        </div>
                        <div class="text">
                            <h2>{{ $value->heading }}</h2>
                            <p>
                                {!! $value->text !!}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    
    @if($home_page_item->event_status == 'show')
    <div class="event pt_70">
        <div class="container">
            @if ($home_page_item->event_heading != '' || $home_page_item->event_subheading != '')                
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>{{ $home_page_item->event_heading }}</h2>
                        <p>
                            {{ $home_page_item->event_subheading }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                @foreach ($events as $value)  
                @php
                    $current_timestamp = strtotime(date('Y-m-d H:i'));
                    $event_timestamp = strtotime($value->date.' '.$value->time);
                @endphp

                @if ($event_timestamp < $current_timestamp)
                @continue  
                @endif

                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="{{ asset('uploads/events/'.$value->featured_photo) }}" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="{{ url('events/'.$value->slug) }}">{{ $value->name }}</a>
                            </h2>
                            <div class="date-time">
                                <i class="fas fa-calendar-alt"></i> 
                                @php
                                    $date = \Carbon\Carbon::parse($value->date)->format('j M, Y');
                                    $time = \Carbon\Carbon::parse($value->time)->format('h:i A');
                                @endphp
                                {{ $date }},{{ $time }}
                            </div>
                            <div class="short-des">
                                <p>
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
    @endif

    @if($home_page_item->testimonial_status == 'show')
    <div class="testimonial pt_70 pb_70" style="background-image: url({{ asset('uploads/home-page-item/'.$home_page_item->testimonial_background) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-header">{{ $home_page_item->heading }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-carousel owl-carousel">
                        @foreach ($testimonials as $key => $value)
                            <div class="item">
                                <div class="photo">
                                    <img src="{{ asset('uploads/testimonials/'.$value->photo) }}" alt="" />
                                </div>
                                <div class="text">
                                    <h4>{{ $value->name }}</h4>
                                    <p>{{ $value->designation }}</p>
                                </div>
                                <div class="description">
                                    <p>
                                        {!! $value->comment !!}
                                    </p>
                                </div>
                            </div>                            
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($home_page_item->blog_status == 'show')
    <div class="blog pt_70">
        <div class="container">
            @if ($home_page_item->blog_heading != '' || $home_page_item->blog_subheading != '')      
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>{{ $home_page_item->blog_heading }}</h2>
                        <p>
                            {{ $home_page_item->blog_subheading }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                @foreach ($posts as $value)                    
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
            </div>
        </div>
    </div>
    @endif


@endsection