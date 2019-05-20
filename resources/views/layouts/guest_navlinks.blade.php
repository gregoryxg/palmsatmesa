<li class="@yield('active_home')">
    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
</li>
<li class="nav-item dropdown @yield('active_about')">
    <a href="#" id="aboutDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About</a>
    <div class="dropdown-menu bg-dark" aria-labelledby="calendarDropdown">
        <a class="dropdown-item @yield('active_privacy')" href="/privacy">Privacy</a>
        <a class="dropdown-item @yield('active_terms')" href="/terms">Terms of Service</a>
    </div>
</li>