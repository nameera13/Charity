@extends('front.layout.default')
@section('title','Cause Detail')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $cause->name }}</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('causes') }}">Causes</a></li>
                        <li class="breadcrumb-item active">{{ $cause->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cause-detail pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="left-item">
                    <div class="main-photo">
                        <img src="{{ asset('uploads/causes/'.$cause->featured_photo) }}" alt="">
                    </div>
                    @php
                        $percentage = ($cause->raised / $cause->goal) * 100;
                        $percentage = ceil($percentage);
                    @endphp
                    <div class="progress mb_10">
                        <div class="progress-bar w-0" role="progressbar" aria-label="Example with label" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="70" style="animation: progressAnimation1 2s linear forwards;"></div>
                        <style>
                            @keyframes progressAnimation1 {
                                from {
                                    width: 0;
                                }to {
                                    width: {{ $percentage }}%;
                                }
                            }
                        </style>
                    </div>
                    <div class="lbl mb_20">
                        <div class="goal">Goal: {{ $cause->goal }}</div>
                        <div class="raised">Raised: {{ $cause->raised }}</div>
                    </div>
                    <p>
                        {!! $cause->description !!}    
                    </p>
                </div>
                <div class="left-item">
                    <h2>
                        Photos
                    </h2>
                    <div class="photo-all">
                        <div class="row">
                            @foreach ($cause_photos as $value)                                
                            <div class="col-md-6 col-lg-4">
                                <div class="item">
                                    <a href="{{ asset('uploads/cause-photo/'.$value->photo) }}" class="magnific">
                                        <img src="{{ asset('uploads/cause-photo/'.$value->photo) }}" alt="" />
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
                            @foreach ($cause_videos as $value)                                
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

                <div class="left-item faq-cause">
                    <h2>
                        FAQ
                    </h2>
                    <div class="accordion" id="accordionExample">
                        @foreach ($cause_faqs as $value)                            
                        <div class="accordion-item mb_30">
                            <h2 class="accordion-header" id="heading_{{ $loop->iteration }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse_{{ $loop->iteration }}">
                                    {{ $value->question }}
                                </button>
                            </h2>
                            <div id="collapse_{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $loop->iteration }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $value->answer }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="right-item">
                    <h2>Donate Now</h2>
                    <form id="donate-form" method="POST">
                        @csrf
                        <input type="hidden" name="cause_id" value="{{ $cause->id }}">
                        <div class="donate-sec">
                            <h3>How much would you like to donate?</h3>
                            <div class="donate-box mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" name="price" class="form-control" id="donation-amount">
                                </div>
                                <span class="text-danger">
                                    <div class="error_price"></div>
                                </span>
                            </div>
                            <h3>Select an Amount:</h3>
                            <div class="donate-select">
                                <ul>
                                    <li>
                                        <button type="button" class="btn btn-primary donation-button" data-amount="10">₹10</button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary donation-button" data-amount="25">₹25</button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary donation-button selected" data-amount="50">₹50</button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary donation-button" data-amount="100">₹100</button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary donation-button" data-amount="">Custom</button>
                                    </li>
                                </ul>
                            </div>
                            <h3>Select Payment Method:</h3>
                            <div class="form-control">
                                <select name="payment_method" class="form-select">
                                    <option value="Razorpay">Razorpay</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger w-100-p donate-now">Donate Now</button>
                        </div>
                    </form>
                    <h2 class="mt_30">Information</h2>
                    <div class="summary">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>Goal</b></td>
                                    <td>{{ $cause->goal }}</td>
                                </tr>
                                <tr>
                                    <td><b>Raised</b></td>
                                    <td>{{ $cause->raised }}</td>
                                </tr>
                                <tr>
                                    <td><b>Remaining</b></td>
                                    <td>{{ $cause->goal - $cause->raised }}</td>
                                </tr>
                                <tr>
                                    <td><b>Percentage</b></td>
                                    <td>
                                        @php                                            
                                            $percentage = ($cause->raised / $cause->goal)*100;
                                            $percentage = Ceil($percentage);
                                        @endphp
                                        {{ $percentage }}%
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Total Persons Donated</b></td>
                                    <td>0</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h2 class="mt_30">Recent Causes</h2>
                    <ul>
                        @foreach ($recent_causes as $value)                            
                            <li><a href="{{ url('causes/'.$value->slug) }}"><i class="fas fa-angle-right"></i> {{ $value->name }}</a></li>
                        @endforeach 
                    </ul>

                    <h2 class="mt_30">Cause Enquery</h2>
                    <div class="enquery-form">
                        <form action="{{ url('causes/send-message') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cause_id" value="{{ $cause->id }}">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Full Name" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="text" name="mobile_no" class="form-control" placeholder="Phone Number" />
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
        $(document).ready(function () {
            // $('.donate-now').on('click', function() {
            //     let form = $('#donate-form');
            //     let formData = form.serialize();
                
            //     // Check if user is Login or Not
            //     @if (!auth()->check())
            //         window.location.href = "{{ route('login') }}"; 
            //         return; 
            //     @endif

            //     $.ajax({
            //         url: "{{ url('donation/payment') }}",
            //         method: 'POST',
            //         data: formData,
            //         headers: {
            //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //         },
            //         success: function(data) {
            //             if (data.order_id) {
            //                 var options = {
            //                     key: data.razorpay_key,
            //                     amount: data.amount,
            //                     currency: 'INR',
            //                     name: data.name,
            //                     description: 'Donation Payment',
            //                     image: '',
            //                     order_id: data.order_id,
            //                     handler: function (response) {
            //                         window.location.href = "{{ route('donation_payment_success') }}?razorpay_order_id=" + response.razorpay_order_id + "&razorpay_payment_id=" + response.razorpay_payment_id + "&razorpay_signature=" + response.razorpay_signature;
            //                     },
            //                     prefill: {
            //                         name: data.name,
            //                         email: data.email,
            //                         contact: '' 
            //                     },
            //                     notes: {
                                    
            //                     },
            //                     theme: {
            //                         color: '#F37254' 
            //                     }
            //                 };
            //                 var rzp1 = new Razorpay(options);
            //                 rzp1.open();
            //             } else {
            //                 alert('Error: ' + data.error);
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error:', error);
            //         }
            //     });
            // });

            $("#donation-amount").val("50");
            $(".donation-button").on('click',function () {
                $(".donation-button").removeClass("selected");
                var amount = $(this).data("amount");
                $("#donation-amount").val(amount);
                $(this).addClass("selected");
                if (amount === "") {
                    $("#donation-amount").focus();
                }
            });

            $('#donate-form').validate({
                rules: {
                    price: {
                        required: true,
                        number: true,
                        min: 1 
                    },
                    payment_method: {
                        required: true
                    }
                },
                messages: {
                    price: {
                        required: "Please enter a donation amount.",
                        number: "Please enter a valid number.",
                        min: "Donation must be at least ₹1."
                    },
                    payment_method: {
                        required: "Please select a payment method."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "price") {
                        error.insertAfter(".error_price");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {

                    // Check if the user is authenticated
                    @if (!auth()->check())
                        window.location.href = "{{ route('login') }}"; 
                        return; 
                    @endif

                    let formData = $(form).serialize();

                    $.ajax({
                        url: "{{ url('donation/payment') }}",
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
                                    description: 'Donation Payment',
                                    image: '',
                                    order_id: data.order_id,
                                    handler: function (response) {
                                        window.location.href = "{{ route('donation_payment_success') }}?razorpay_order_id=" + response.razorpay_order_id + "&razorpay_payment_id=" + response.razorpay_payment_id + "&razorpay_signature=" + response.razorpay_signature;
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
                                // This part can handle other errors returned from the server
                                if (data.error) {
                                    $(".error_price").text(data.error).show(); // Display error message inline
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            // Optional: Handle any server-side validation errors
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                $(".error_price").text(xhr.responseJSON.error).show(); // Display server-side error
                            }
                        }
                    });
                }
            });

        });
    </script>

@endpush