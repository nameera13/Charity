@extends('front.layout.default')
@section('title','Event Details')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $event->title }}</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('events') }}">Events</a></li>
                        <li class="breadcrumb-item active">Abled child cancer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="event-detail pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="left-item">
                    <div class="main-photo">
                        <img src="{{ asset('admin/uploads/events/'.$event->featured_photo) }}" alt="">
                    </div>
                    <h2>
                        Description
                    </h2>
                    <p>
                        {!! $event->description !!}    
                    </p>
                </div>
                <div class="left-item">
                    <h2>
                        Photos
                    </h2>
                    <div class="photo-all">
                        <div class="row">
                            @foreach ($event_photos as $value)                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="item">
                                        <a href="{{ asset('admin/uploads/event-photo/'.$value->photo) }}" class="magnific">
                                            <img src="{{ asset('admin/uploads/event-photo/'.$value->photo) }}" alt="" />
                                            <div class="icon">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                            <div class="bg"></div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="left-item">
                    <h2>
                        Videos
                    </h2>
                    <div class="video-all">
                        <div class="row">
                            @foreach ($event_videos as $value)                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="item">
                                        <a class="video-button" href="http://www.youtube.com/watch?v={{ $value->youtube_video_id }}">
                                            <img src="http://img.youtube.com/vi/{{ $value->youtube_video_id }}/0.jpg" alt="" />
                                            <div class="icon">
                                                <i class="far fa-play-circle"></i>
                                            </div>
                                            <div class="bg"></div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-12">

                <div class="right-item">
                    @php
                        $current_timestamp = strtotime(date('Y-m-d H:i'));
                        $event_timestamp = strtotime($event->date.' '.$event->time);
                    @endphp
                    @if ($event_timestamp > $current_timestamp)
                        <div class="countdown show" data-Date='{{ $event->date }} {{ $event->time }}'>
                            <div class="boxes running">
                                <div class="box">
                                    <div class="num"><timer><span class="days"></span></timer></div>
                                    <div class="name">Days</div>
                                </div>
                                <div class="box">
                                    <div class="num"><timer><span class="hours"></span></timer></div>
                                    <div class="name">Hours</div>
                                </div>
                                <div class="box">
                                    <div class="num"><timer><span class="minutes"></span></timer></div>
                                    <div class="name">Minutes</div>
                                </div>
                                <div class="box">
                                    <div class="num"><timer><span class="seconds"></span></timer></div>
                                    <div class="name">Seconds</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-danger fw-bold fs-4">Event Date is Over!</div>
                    @endif
                    <h2 class="mt_30">Event Information</h2>
                    <div class="summary">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                @if($event->price != 0)
                                <tr>
                                    <td><b>Ticket Price</b></td>
                                    <td class="price">{{ $event->price }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><b>Location</b></td>
                                    <td>{{ $event->location }}</td>
                                </tr>
                                <tr>
                                    <td><b>Date</b></td>
                                    <td>{{ $event->date }}</td>
                                </tr>
                                <tr>
                                    <td><b>Time</b></td>
                                    <td>{{ $event->time }}</td>
                                </tr>
                                @if ($event->total_seat != '')                                    
                                    <tr>
                                        <td><b>Total Seat</b></td>
                                        <td>{{ $event->total_seat }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Booked</b></td>
                                        <td>
                                            @if ($event->booked_seat == '')
                                                0
                                            @else
                                                {{ $event->booked_seat }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Remaining</b></td>
                                        <td>
                                            @php
                                                $remaining = $event->total_seat - $event->booked_seat;
                                            @endphp
                                            {{ $remaining }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if ($event_timestamp > $current_timestamp)
                        @if ($event->price != 0)                        
                            <h2 class="mt_30">Buy Ticket</h2>
                            <div class="pay-sec">
                                <form action="" method="post">
                                    @csrf
                                    <select name="number_of_tickets" class="form-select mb_15">
                                        <option value="">How Many Tickets</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                        <option value="">4</option>
                                        <option value="">5</option>
                                        <option value="">6</option>
                                    </select>
                                    <select name="payment_method" class="form-select mb_15">
                                        <option value="">Select Payment Method</option>
                                        <option value="">PayPal</option>
                                        <option value="">Stripe</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary w-100-p pay-now">Make Payment</button>
                                </form>
                            </div>
                        @endif

                        @if ($event->price == 0)
                            <h2 class="mt_30">Free Booking</h2>
                            <div class="pay-sec">       
                                <form action="" method="POST">
                                    @csrf    
                                    <select name="number_of_tickets" class="form-select mb_15">
                                        <option value="">How Many Tickets</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>                 
                                    <button type="submit" class="btn btn-primary w-100-p pay-now">Book Now</button>
                                </form>
                            </div>
                        @endif
                    @endif
            
                    @if ($event->map != '')                        
                        <h2 class="mt_30">Event Location</h2>
                        <div class="location-map">
                            {!! $event->map !!}
                        </div>
                    @endif

                    <h2 class="mt_30">Recent Events</h2>
                    <ul>
                        @foreach ($recent_events as $value)                            
                            <li><a href="{{ url('events/'.$value->slug) }}"><i class="fas fa-angle-right"></i> {{ $value->name }}</a></li>
                        @endforeach         
                    </ul>
                
                    <h2 class="mt_30">Event Enquery</h2>
                    <div class="enquery-form">
                        <form action="{{ url('events/enquery') }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="name" placeholder="Full Name" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="mobile_no" placeholder="Phone Number (Optional)" />
                                @error('mobile_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control h-150" name="message" rows="3" placeholder="Message"></textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Send Message <i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

@endsection