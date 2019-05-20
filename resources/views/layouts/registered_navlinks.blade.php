<li class="nav-item dropdown @yield('active_events')">
    <a href="#" id="calendarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Events</a href="#">
    <div class="dropdown-menu bg-dark" aria-labelledby="calendarDropdown"> {{--@yield('active_events')--}}
        <a class="dropdown-item @yield('active_calendar')" href="/event">Calendar</a>
    @if (Auth::user()->resident_status->add_to_calendar)
        <a class="dropdown-item @yield('active_new_reservation')" href="/event/create">New Reservation</a>
    @endif
    </div>
</li>