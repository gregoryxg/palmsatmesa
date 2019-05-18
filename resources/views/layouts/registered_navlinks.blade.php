<li class="@yield('active_events')">
    <a class="nav-link" href="/event">Calendar</a>
</li>
@if (Auth::user()->resident_status->add_to_calendar)
    <li class="@yield('active_events')">
        <a class="nav-link" href="/event/create">New Reservation</a>
    </li>
@endif