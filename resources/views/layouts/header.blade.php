<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
    </head>
    <body>
        <a href="/">Home</a>
        <a href="/contact">Contact us</a>
        <a href="/about">About</a>
        <a href="/projects">Projects</a>

        @yield('content')

    </body>
</html>
