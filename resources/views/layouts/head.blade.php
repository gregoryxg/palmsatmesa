<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
    <meta name="description" content="">
    <meta name="author" content="Gregory Gonzalez">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset(Storage::url('public/logo/ThePalms.png')) }}">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">

    <!-- events.calendar.blade.php -->
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet">
    
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

</head>