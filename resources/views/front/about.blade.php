@extends('front.layout.default')
@section('title','About Us')
@section('front')

<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>About Us</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">About Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

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


<div class="counter-section pt_70 pb_70">
    <div class="container">
        <div class="row counter-items">
            <div class="col-md-3 counter-item">
                <div class="counter">{{ $counters->counter1_number }}</div>
                <div class="text">{{ $counters->counter1_name }}</div>
            </div>
            <div class="col-md-3 counter-item">
                <div class="counter">{{ $counters->counter2_number }}</div>
                <div class="text">{{ $counters->counter2_name }}</div>
            </div>
            <div class="col-md-3 counter-item">
                <div class="counter">{{ $counters->counter3_number }}</div>
                <div class="text">{{ $counters->counter3_name }}</div>
            </div>
            <div class="col-md-3 counter-item">
                <div class="counter">{{ $counters->counter4_number }}</div>
                <div class="text">{{ $counters->counter4_name }}</div>
            </div>
        </div>
    </div>
</div>
@endsection