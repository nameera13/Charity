<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="icon" type="image/png" href="{{ asset('admin/uploads/no-img.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @include('admin.include.css')

    @stack('styles')        

    @include('admin.include.js')
    
</head>

<body>
    
    <div id="app">
        <div class="main-wrapper">

            @include('admin.include.header')
        
            @include('admin.include.sidebar')

            <div class="main-content">

                @yield('admin')
                
            </div>

        </div>
    </div>

    @include('admin.include.custom')

    @stack('scripts')

</body>
</html>