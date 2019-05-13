<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/"><img src='{{ asset('img/ThePalms.png') }}' width="100px"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            @guest
            <ul class="navbar-nav mr-auto">
                @include('layouts.guest_navlinks')
                <li class="@yield('active_new_residents')">
                    <a class="nav-link" href="/new_residents">New Residents</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="/register"><i class="fas fa-user-plus"></i> Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login/"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
            </ul>
            @else
                <ul class="navbar-nav mr-auto">
                    <li class="nav-link text-light">
                        Welcome {{ Auth::user()->first_name }}
                    </li>
                    @include('layouts.guest_navlinks')
                    @include('layouts.lessee_navlinks')
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <a class="nav-link" href="/user/{{ Auth::user()->id }}"><i class="fas fa-user-cog"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                </ul>
            @endguest
        </div>
    </nav>
</header>