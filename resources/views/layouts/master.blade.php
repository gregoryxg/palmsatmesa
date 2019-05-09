<html lang="en">

    @include('layouts.head')

    <body style="">

    @include('layouts.navbar')

        <main role="main">

            @yield('content')

            @include('layouts.footer')

        </main>

        @include('layouts.js')

    </body>

</html>