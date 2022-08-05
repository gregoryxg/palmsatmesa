@if (Auth::user()->account_approved)
    <li class="nav-item dropdown @yield('active_events')">
        <a href="#" id="calendarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Events</a>
        <div class="dropdown-menu bg-dark" aria-labelledby="calendarDropdown">
            <a class="dropdown-item @yield('active_calendar')" href="/event">Calendar</a>
        @if (Auth::user()->resident_status->add_to_calendar)
            <a class="dropdown-item @yield('active_my_reservations')" href="/reservations">My Reservations</a>
            <a class="dropdown-item @yield('active_new_reservation')" href="/event/create">New Reservation</a>
        @endif
        </div>
    </li>
@endif
<li class="nav-item dropdown @yield('active_support')">
    <a href="#" id="supportDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Support/Maintenance</a>
    <div class="dropdown-menu bg-dark" aria-labelledby="supportDropdown">
        <a class="dropdown-item @yield('ticket')" href="/ticket">My Open Tickets</a>
        <a class="dropdown-item @yield('closed_ticket')" href="/closed_ticket">My Closed Tickets</a>
        <a class="dropdown-item @yield('active_new_ticket')" href="/ticket/create">New Ticket</a>
        @if(Auth::user()->committees->count() > 0)
            <a class="dropdown-item @yield('committeeticket')" href="/committeeticket">Open Committee Tickets</a>
            <a class="dropdown-item @yield('user_committeeticket')" href="/user_committeeticket">My Committee Tickets</a>
            <a class="dropdown-item @yield('assigned_committeeticket')" href="/assigned_committeeticket">Assigned Committee Tickets</a>
            <a class="dropdown-item @yield('closed_committeeticket')" href="/closed_committeeticket">Closed Committee Tickets</a>
        @endif
    </div>
</li>