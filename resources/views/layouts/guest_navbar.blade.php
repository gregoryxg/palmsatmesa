<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/"><img src='{{ asset('img/ThePalms.png') }}' width="100px"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="@yield('active_home')">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="@yield('active_new_residents')">
                    <a class="nav-link" href="/new_residents">New Residents</a>
                </li>
                <li class="@yield('active_privacy')">
                    <a class="nav-link" href="/privacy">Privacy</a>
                </li>
                <li class="@yield('active_terms')">
                    <a class="nav-link" href="/terms">Terms of Service</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="/register"><i class="fas fa-user"></i> Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login/"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
            </ul>
        </div>
    </nav>
</header>