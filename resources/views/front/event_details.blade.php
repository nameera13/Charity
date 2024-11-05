@extends('front.layout.default')
@section('title','Event Details')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $event->name }}</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('events') }}">Events</a></li>
                        <li class="breadcrumb-item active">{{ $event->name }}</li>
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
                        <img src="{{ asset('uploads/events/'.$event->featured_photo) }}" alt="">
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
                                        <a href="{{ asset('uploads/event-photo/'.$value->photo) }}" class="magnific">
                                            <img src="{{ asset('uploads/event-photo/'.$value->photo) }}" alt="" />
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
                                @else
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
                                @endif
                            </table>
                        </div>
                    </div>

                    @if ($event_timestamp > $current_timestamp)
                        @if ($event->price != 0)                        
                            <h2 class="mt_30">Buy Ticket</h2>
                            <div class="pay-sec">
                                <form id="payment-form" method="POST">
                                    @csrf
                                    <input type="hidden" name="unit_price" value="{{ $event->price }}">
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                                    <div class="form-group mb_15">                                       
                                        <select name="number_of_tickets" class="form-select">
                                            <option value="">How Many Tickets</option>
                                            @for ($i = 1; $i <=5; $i++)                                           
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <span class="text-danger">
                                            <div class="error_number_of_tickets"></div>
                                        </span>
                                    </div>
                                    <div class="form-group mb_15">                                       
                                        <select name="payment_method" class="form-select mb_15">
                                            <option value="Razorpay">Razorpay</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-primary w-100-p pay-now">Make Payment</button>
                                </form>
                            </div>
                        @endif

                        @if ($event->price == 0)
                            <h2 class="mt_30">Free Booking</h2>
                            <div class="pay-sec">       
                                <form action="{{ url('events/ticket/free-booking') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="unit_price" value="{{ $event->price }}">
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">  
                                    
                                    <div class="form-group mb_15">
                                        <select name="number_of_tickets" class="form-select">
                                            <option value="">How Many Tickets</option>
                                            @for ($i = 1; $i <=5; $i++)                                           
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>    
                                        @error('number_of_tickets')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror  
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100-p">Book Now</button>
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
@push('script')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(document).ready(function() {
            $('#payment-form').validate({
                rules: {
                    number_of_tickets: {
                        required: true            
                    },
                    payment_method: {
                        required: true
                    },
                },
                messages: {
            
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "number_of_tickets") {
                        error.insertAfter(".error_number_of_tickets");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    // Check if user is Login or Not
                    @if (!auth()->check())
                        window.location.href = "{{ route('login') }}"; 
                        return; 
                    @endif

                    let formData = $(form).serialize();

                    $.ajax({
                        url: "{{ url('events/ticket/payment') }}",
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.order_id) {
                                var options = {
                                    key: data.razorpay_key,
                                    amount: data.amount,
                                    currency: 'INR',
                                    name: data.name,
                                    description: 'Event Payment',
                                    image: '',
                                    order_id: data.order_id,
                                    handler: function (response) {
                                        window.location.href = "{{ route('event_ticket_razorpay_success') }}?razorpay_order_id=" + response.razorpay_order_id + "&razorpay_payment_id=" + response.razorpay_payment_id + "&razorpay_signature=" + response.razorpay_signature;
                                    },
                                    prefill: {
                                        name: data.name,
                                        email: data.email,
                                        contact: '' 
                                    },
                                    notes: {},
                                    theme: {
                                        color: '#F37254' 
                                    }
                                };
                                var rzp1 = new Razorpay(options);
                                rzp1.open();
                            } else {
                                alert('Error: ' + data.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });

            $('.pay-now').on('click', function() {
                $('#payment-form').submit(); 
            });
    
        });
    </script>

@endpush