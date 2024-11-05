@extends('front.layout.default')
@Section('title','Contact Us')
@section('front')
<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Contact Us</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Contact Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact pt_70">
    <div class="container">
        <div class="row">
            @if ($global_setting_data->map == '')                
                @php
                    $column = 12;
                @endphp
            @else
                @php
                    $column = 6;
                @endphp
            @endif
            <div class="col-lg-{{ $column }} col-md-12">
                <div class="contact-form pb_70">
                    <form action="{{ url('contact-us') }}" method="POST" id="contactUs">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control">
                            <span class="text-danger">
                                <div class="error_name"></div>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address</label>
                            <input type="text" name="email" class="form-control">
                            <span class="text-danger">
                                <div class="error_email"></div>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="3"></textarea>
                            <span class="text-danger">
                                <div class="error_message"></div>
                            </span>
                        </div>
                        <div class="mb-3">
                            <button type="submit" id="submit_form_button">
                                Send Message  <i class="fas fa-long-arrow-alt-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($global_setting_data->map != '')                
            <div class="col-lg-6 col-md-12">
                <div class="map">
                    <iframe src="{{ $global_setting_data->map }}" width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('script')
<script>

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#contactUs").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                message: {
                    required: true,
                }
            },
            messages: {
                
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "name") {
                    error.insertAfter(".error_name");
                } else if (element.attr("name") == "email") {
                    error.insertAfter(".error_email");
                } else if (element.attr("name") == "message") {
                    error.insertAfter(".error_message");
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            submitHandler: function(form) {
                if($("#contactUs").valid()) {
                    var button = document.querySelector("#submit_form_button");
                    button.setAttribute("data-kt-indicator", "on");
                    form.submit();
                } else {
                    return false;
                }
            }
        });
    });
   
</script>
@endpush