<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - WashDepot</title>
    <link rel="stylesheet" href="{{ asset('css/staff/staff-layout.css') }}">
    @yield('styles')
</head>
<body>

    <div class="app-container">

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-top">
                <div class="brand">
                    <div class="brand-logo"></div>
                    <div class="brand-text">
                        <span class="brand-name">WashDepot</span>
                        <span class="brand-role">Staff</span>
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <a href="/staff/new-laundry" class="{{ request()->is('staff/new-laundry') ? 'active' : '' }}">New Laundry Service</a>
                    <a href="/staff/queue" class="{{ request()->is('staff/queue') ? 'active' : '' }}">Queue Management</a>
                    <a href="/staff/inventory" class="{{ request()->is('staff/inventory') ? 'active' : '' }}">Inventory</a>
                </nav>
            </div>

            <div class="sidebar-bottom">
                <a href="/staff/profile">Profile</a>
                <a href="/staff/help">Help & Support</a>
                <a href="/logout" class="logout">Logout</a>
            </div>
        </div>

        <!-- Main -->
        <div class="main-wrapper">

            <!-- Top Bar -->
            <div class="topbar">
                <div class="topbar-right">
                    <!-- Notification Bell -->
                    <div class="notif-bell">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 24 24">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6V11c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                        </svg>
                        <span class="notif-count">3</span>
                    </div>

                    <!-- Staff Info -->
                    <div class="staff-info">
                        <span class="staff-name">Staff's Name</span>
                        <span class="staff-team">Team A</span>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="main-content">
                @yield('content')
            </div>

        </div>
    </div>

</body>
</html>