<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <title>@yield('title')</title>

    <link rel="icon" type="image/png" href="{{ asset('uploads/no-img.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @include('admin.include.css')

    @include('admin.include.js')
    
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        @yield('admin')
    </div>
</div>

    @include('admin.include.custom')

</body>
</html>