<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - WashDepot</title>
        <link rel="stylesheet" href="{{ asset('css/variables.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/admin-layout.css') }}">
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
                        <span class="brand-role">Admin/Owner</span>
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <a href="/admin/shop-management" class="{{ request()->is('admin/shop-management') ? 'active' : '' }}">Shop Management</a>
<a href="/admin/update-template" class="{{ request()->is('admin/update-template') ? 'active' : '' }}">
    Update Template
</a>                    <a href="/admin/inventory" class="{{ request()->is('admin/inventory-management') ? 'active' : '' }}">Inventory Management</a>
                    <a href="/admin/reports" class="{{ request()->is('admin/reports') ? 'active' : '' }}">Reports / Sales</a>
                    <a href="/admin/account-management" class="{{ request()->is('admin/account-management') ? 'active' : '' }}">Account Management</a>

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
                        <span class="notif-count></span>
                    </div>

                    <!-- Staff Info -->
                    <div class="staff-info">
                        <span class="staff-name">Admin's Name</span>
                        <span class="staff-team"></span>
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