@if ($global_setting_data->cta_status == 'show')
<div class="cta">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="left mt_50 mb_50 xs_mb_30">
                    <h2>{{ $global_setting_data->cta_heading }}</h2>
                    <p>{{ $global_setting_data->cta_text }}</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="right">
                    <div class="inner">
                        <a href="{{ $global_setting_data->cta_button_url }}"> {{ $global_setting_data->cta_button_text }} <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="footer pt_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="item pb_50">
                    <h2 class="heading">Important Pages</h2>
                    <ul class="useful-links">
                        <li><a href="/"><i class="fas fa-angle-right"></i> Home</a></li>
                        <li><a href="{{ url('causes') }}"><i class="fas fa-angle-right"></i> Causes</a></li>
                        <li><a href="{{ url('events') }}"><i class="fas fa-angle-right"></i> Events</a></li>
                        <li><a href="{{ url('volunteers') }}"><i class="fas fa-angle-right"></i> Volunteers</a></li>
                        <li><a href="{{ url('blog') }}"><i class="fas fa-angle-right"></i> Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="item pb_50">
                    <h2 class="heading">Useful Links</h2>
                    <ul class="useful-links">
                        <li><a href="{{ url('faqs') }}"><i class="fas fa-angle-right"></i> FAQ</a></li>
                        <li><a href="{{ url('terms-and-conditions') }}"><i class="fas fa-angle-right"></i> Terms of Use</a></li>
                        <li><a href="{{ url('privacy-policy') }}"><i class="fas fa-angle-right"></i> Privacy Policy</a></li>
                        <li><a href="{{ url('about') }}"><i class="fas fa-angle-right"></i> About Us</a></li>
                        <li><a href="{{ url('contact-us') }}"><i class="fas fa-angle-right"></i> Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="item pb_50">
                    <h2 class="heading">Contact</h2>
                    <div class="list-item">
                        @if ($global_setting_data->footer_address != '') 
                        <div class="left">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="right">
                            {{ $global_setting_data->footer_address }}
                        </div>
                        @endif
                    </div>
                    <div class="list-item">
                        @if ($global_setting_data->footer_phone != '') 
                        <div class="left">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="right">{{ $global_setting_data->footer_phone }}</div>
                        @endif
                    </div>
                    <div class="list-item">
                        @if ($global_setting_data->footer_email != '') 
                        <div class="left">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="right">{{ $global_setting_data->footer_email }}</div>
                        @endif
                    </div>
                    <ul class="social">
                        @if ($global_setting_data->facebook != '') 
                        <li><a href="{{ $global_setting_data->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                        @endif

                        @if ($global_setting_data->twitter != '') 
                        <li><a href="{{ $global_setting_data->twitter }}"><i class="fab fa-twitter"></i></a></li>
                        @endif
                        
                        @if ($global_setting_data->youtube != '') 
                        <li><a href="{{ $global_setting_data->youtube }}"><i class="fab fa-youtube"></i></a></li>
                        @endif
                        
                        @if ($global_setting_data->linkedin != '') 
                        <li><a href="{{ $global_setting_data->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                        @endif
                        
                        @if ($global_setting_data->instagram != '') 
                        <li><a href="{{ $global_setting_data->instagram }}"><i class="fab fa-instagram"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="item pb_50">
                    <h2 class="heading">Newsletter</h2>
                    <p>
                        To get the latest news from our website, please
                        subscribe us here:
                    </p>
                    <form action="{{ url('subscriber') }}" id="subscriber" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Email Address">
                            <span class="text-danger">
                                <div class="error_email"></div>
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="subscriber_submit" class="btn btn-primary" value="Subscribe Now">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="copyright">
                    {{ $global_setting_data->copyright }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#subscriber").validate({
                rules: {
                   email: {
                        required: true,
                        email: true,
                    }
                },
                messages: {
                    
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "email") {
                        error.insertAfter(".error_email");
                    } else {
                        error.insertAfter(element);
                    }
                },
                ignore: [],
                submitHandler: function(form) {
                    if($("#subscriber").valid()) {
                        var button = document.querySelector("#subscriber_submit");
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