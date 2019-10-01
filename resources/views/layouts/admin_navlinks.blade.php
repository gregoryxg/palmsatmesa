
<li class="nav-item dropdown @yield('active_admin')">
    <a href="#" id="adminDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tools"></i> Admin</a>
    <div class="dropdown-menu bg-dark" aria-labelledby="adminDropdown">
        <a class="dropdown-item @yield('active_dashboard')" href="/admin">Dashboard</a>
        <a class="dropdown-item @yield('active_users')" href="/admin/users">Users</a>
        <a class="dropdown-item @yield('active_reservables')" href="/admin/reservables">Reservables</a>
        <a class="dropdown-item @yield('active_units')" href="/admin/units">Units</a>
    </div>
</li>
