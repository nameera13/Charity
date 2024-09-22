<div class="top">
    <div class="container">
        <div class="row">
            <div class="col-md-6 left-side">
                <ul>
                    <li class="phone-text"><i class="fas fa-phone"></i> 111-222-3333</li>
                    <li class="email-text"><i class="fas fa-envelope"></i> contact@example.com</li>
                </ul>
            </div>
            <div class="col-md-6 right-side">
                <ul class="right">
                    @auth
                        <li class="menu">
                            <a href="{{ url('/dashboard') }}"><i class="fas fa-sign-in-alt"></i> Dashboard</a>
                        </li>
                    @else
                        <li class="menu">
                            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="menu">
                                <a href="{{ route('register') }}"><i class="fas fa-user"></i> Sign Up</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="navbar-area" id="stickymenu">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="/" class="logo">
            <img src="{{ asset('front/uploads/logo.png') }}" alt="">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('front/uploads/logo.png') }}" alt="">
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
                            <a href="{{ url('/about') }}" class="nav-link">About</a>
                        </li>
                        <li class="nav-item {{ Request::is('events') ? 'active' : '' }}">
                            <a href="{{ url('/events') }}" class="nav-link">Events</a>
                        </li>
                        <li class="nav-item">
                            <a href="causes.html" class="nav-link">Causes</a>
                        </li>
                        <li class="nav-item {{ Request::is('volunteers') ? 'active' : '' }}">
                            <a href="{{ url('/volunteers') }}" class="nav-link">Volunteers</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void;" id="galleryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Gallery
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="galleryDropdown">
                                <li><a class="dropdown-item" href="{{ url('photo-gallery') }}">Photo Gallery</a></li>
                                <li><a class="dropdown-item" href="{{ url('video-gallery') }}">Video Gallery</a></li>
                            </ul>
                        </li>
                        <li class="nav-item {{ Request::is('faqs') ? 'active' : '' }}">
                            <a href="{{ url('faqs') }}" class="nav-link">FAQ</a>
                        </li>
                        <li class="nav-item {{ Request::is('blog') ? 'active' : '' }}">
                            <a href="{{ url('blog') }}" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="contact.html" class="nav-link">Contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>