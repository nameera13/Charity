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
                                    <div class="right-side" style="background-image: url({{ asset('admin/uploads/specials/'.$special->photo) }});">
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

    <div class="cause pt_70">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Featured Causes</h2>
                        <p>
                            Our organization focuses on providing services to the homeless peoples.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/cause-1.jpg" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="cause.html">Child Support</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    To provide food, shelter, clothing, education and medical assistance to homeless children and their families.
                                </p>
                            </div>
                            <div class="progress mb_10">
                                <div class="progress-bar w-0" role="progressbar" aria-label="Example with label" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70" style="animation: progressAnimation1 2s linear forwards;"></div>
                                <style>
                                    @keyframes progressAnimation1 {from {width: 0;}to {width: 70%;}}
                                </style>
                            </div>
                            <div class="lbl mb_20">
                                <div class="goal">Goal: $4000</div>
                                <div class="raised">Raised: $3500</div>
                            </div>
                            <div class="button-style-2">
                                <a href="cause.html">Donate Now <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/cause-2.jpg" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="cause.html">Help to Mothers</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    To help the mothers who are homeless & helpless, we provide them food, shelter & medical assistance.
                                </p>
                            </div>
                            <div class="progress mb_10">
                                <div class="progress-bar w-0" role="progressbar" aria-label="Example with label" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="animation: progressAnimation2 2s linear forwards;"></div>
                                <style>
                                    @keyframes progressAnimation2 {from {width: 0;}to {width: 90%;}}
                                </style>
                            </div>
                            <div class="lbl mb_20">
                                <div class="goal">Goal: $5000</div>
                                <div class="raised">Raised: $4500</div>
                            </div>
                            <div class="button-style-2">
                                <a href="cause.html">Donate Now <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/cause-3.jpg" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="cause.html">Water for All</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    To provide clean water to the homeless peoples, we have taken a project to provide them clean water.
                                </p>
                            </div>
                            <div class="progress mb_10">
                                <div class="progress-bar w-0" role="progressbar" aria-label="Example with label" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="animation: progressAnimation3 2s linear forwards;"></div>
                                <style>
                                    @keyframes progressAnimation3 {from {width: 0;}to {width: 30%;}}
                                </style>
                            </div>
                            <div class="lbl mb_20">
                                <div class="goal">Goal: $3000</div>
                                <div class="raised">Raised: $1000</div>
                            </div>
                            <div class="button-style-2">
                                <a href="cause.html">Donate Now <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if($feature_section_items->status == 'show')
        <div class="why-choose pt_70" style="background-image: url({{ asset('admin/uploads/feature-item/'.$feature_section_items->photo) }})">
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

    
    <div class="event pt_70">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Upcoming Events</h2>
                        <p>
                            You can organize events and help us to raise fund for the poor people.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/event-1.jpg" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="event.html">Abled child cancer</a>
                            </h2>
                            <div class="date-time">
                                <i class="fas fa-calendar-alt"></i> 23 Sep 2023, 09:30 AM
                            </div>
                            <div class="short-des">
                                <p>
                                    To provide food, shelter, clothing, education and medical assistance to homeless children and their families.
                                </p>
                            </div>
                            <div class="button-style-2">
                                <a href="event.html">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/event-2.jpg" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="event.html">Contribute for Recovery</a>
                            </h2>
                            <div class="date-time">
                                <i class="fas fa-calendar-alt"></i> 23 Sep 2023, 09:30 AM
                            </div>
                            <div class="short-des">
                                <p>
                                    To help the mothers who are homeless & helpless, we provide them food, shelter & medical assistance.
                                </p>
                            </div>
                            <div class="button-style-2">
                                <a href="event.html">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/event-3.jpg" alt="">
                        </div>
                        <div class="text">
                            <h2>
                                <a href="event.html">Playing For World</a>
                            </h2>
                            <div class="date-time">
                                <i class="fas fa-calendar-alt"></i> 23 Sep 2023, 09:30 AM
                            </div>
                            <div class="short-des">
                                <p>
                                    To provide clean water to the homeless peoples, we have taken a project to provide them clean water.
                                </p>
                            </div>
                            <div class="button-style-2">
                                <a href="event.html">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($testimonial_section_items->status == 'show')
        <div class="testimonial pt_70 pb_70" style="background-image: url({{ asset('admin/uploads/testimonial-item/'.$testimonial_section_items->photo) }})">
            <div class="bg"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="main-header">{{ $testimonial_section_items->heading }}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="testimonial-carousel owl-carousel">
                            @foreach ($testimonials as $key => $value)
                                <div class="item">
                                    <div class="photo">
                                        <img src="{{ asset('admin/uploads/testimonials/'.$value->photo) }}" alt="" />
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

    <div class="blog pt_70">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Latest News</h2>
                        <p>
                            Check out the latest news and updates from our blog post
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/blog-1.jpg" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="post.html">Partnering to create a strong community</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    In order to create a good community we need to work together. We need to help, support each other and be respectful to each other.
                                </p>
                            </div>
                            <div class="button-style-2 mt_20">
                                <a href="post.html">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/blog-2.jpg" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="post.html">Turning your emergency donation into instant aid</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    We are working hard to help the poor people. We are trying to provide them food, shelter, clothing, education and medical assistance.
                                </p>
                            </div>
                            <div class="button-style-2 mt_20">
                                <a href="post.html">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item pb_70">
                        <div class="photo">
                            <img src="uploads/blog-3.jpg" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="post.html">Charity provides educational boost for children</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    In order boost the education of the children, we are providing them books, pens, pencils, notebooks and other necessary things.
                                </p>
                            </div>
                            <div class="button-style-2 mt_20">
                                <a href="post.html">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection