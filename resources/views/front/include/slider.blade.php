<div class="slider">
    <div class="slide-carousel owl-carousel">
        @foreach ($sliders as $slider)

        <div class="item" style="background-image:url( {{ asset('uploads/sliders/' . $slider->photo) }} );">
            <div class="bg"></div>
            <div class="text">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-wrapper">
                                <div class="text-content">
                                    <h2>{{ $slider->heading }}</h2>
                                    <p>
                                        {!! $slider->text !!}                                    
                                    </p>
                                    <div class="button-style-1 mt_20">
                                        <a href="{{ $slider->btn_link }}">{{ $slider->btn_text }} <i class="fas fa-long-arrow-alt-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
        {{-- <div class="item" style="background-image:url( {{ asset('front/uploads/slide-2.jpg')}} );">
            <div class="bg"></div>
            <div class="text">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-wrapper">
                                <div class="text-content">
                                    <h2>Fight for right <br>causes</h2>
                                    <p>
                                        We work hard to support and raise awareness for important issues that need attention and action. Our goal is to make the world a better place by advocating for justice, equality, and positive change. Your support and involvement can help a lot.
                                    </p>
                                    <div class="button-style-1">
                                        <a href="">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>