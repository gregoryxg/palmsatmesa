<li class="nav-item dropdown @yield('active_events')">
    <a href="#" id="calendarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Events</a>
    <div class="dropdown-menu bg-dark" aria-labelledby="calendarDropdown">
        <a class="dropdown-item @yield('active_calendar')" href="/event">Calendar</a>
    @if (Auth::user()->resident_status->add_to_calendar)
        <a class="dropdown-item @yield('active_new_reservation')" href="/event/create">New Reservation</a>
            <a class="dropdown-item @yield('active_my_reservations')" href="/reservations">My Reservations</a>
    @endif
    </div>
</li>