<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title')</title>

        <link rel="icon" type="image/png" href="{{ asset('front/uploads/favicon.png') }}">

        <!-- All CSS -->
        @include('front.include.css')
        <!-- All Javascripts -->
        @include('front.include.js')
        
        <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        
        @include('front.include.header')
        
        @yield('front')

        @include('front.include.footer')

        <div class="scroll-top">
            <i class="fas fa-angle-up"></i>
        </div>

        <script src="{{ asset('front/js/custom.js') }}"></script>

        @stack('script')
        
        @include('front.include.custom')

    </body>
</html>
