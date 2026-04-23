<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — WashDepot</title>

    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/staff/staff-layout.css') }}">
    @yield('styles')
</head>
<body>

<div class="app-container">

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">

        <div class="sidebar-top">
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/washdepot-logo.png') }}" alt="WashDepot"
                         onerror="this.style.display='none'">
                </div>
                <div class="brand-text">
                    <span class="brand-name">WashDepot</span>
                    <span class="brand-role">Staff</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ url('/staff/new-laundry') }}"
                   class="{{ request()->is('staff/new-laundry') ? 'active' : '' }}">
                    New Laundry Service
                </a>
                <a href="{{ url('/staff/queue') }}"
                   class="{{ request()->is('staff/queue') ? 'active' : '' }}">
                    Queue Management
                </a>
                <a href="{{ url('/staff/inventory') }}"
                   class="{{ request()->is('staff/inventory') ? 'active' : '' }}">
                    Inventory
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <a href="{{ url('/staff/profile') }}"
               class="{{ request()->is('staff/profile') ? 'active' : '' }}">
                Profile
            </a>
            <a href="{{ url('/staff/help') }}"
               class="{{ request()->is('staff/help') ? 'active' : '' }}">
                Help &amp; Support
            </a>
            {{-- Logout triggers modal --}}
            <a href="#" onclick="showLogoutModal(); return false;">
                Logout
            </a>
        </div>
    </aside>

    <div class="main-wrapper">

        <div class="topbar">
            <button class="hamburger" id="hamburger"
                    aria-label="Open menu" aria-expanded="false" aria-controls="sidebar">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="topbar-right">

                <div class="notif-bell" id="notifBell" style="position:relative;" role="button"
                     aria-label="Notifications" tabindex="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                         fill="white" viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6V11
                                 c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5
                                 s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2
                                 2v1h16v-1l-2-2z"/>
                    </svg>

                    @php $unreadCount = auth()->user()?->unreadNotifications?->count() ?? 0; @endphp

                    <div class="notif-panel" id="notifPanel">
                        <div class="notif-panel-header">Notifications</div>
                        <div class="notif-list" id="notifList">
                            <div class="notif-empty">No notifications yet</div>
                        </div>
                        <div class="notif-panel-footer">
                            <a href="{{ url('/staff/notifications') }}">View all</a>
                        </div>
                    </div>
                </div>

                <div class="staff-info">
                    <span class="staff-name">{{ auth()->user()?->name ?? "Staff's Name" }}</span>
                    <span class="staff-team">{{ auth()->user()?->team ?? 'Team A' }}</span>
                </div>

            </div>
        </div>

        <div class="main-content">
            @yield('content')
        </div>

    </div>

</div>

{{-- ══════════════════════════════════════
     LOGOUT MODAL
══════════════════════════════════════ --}}
<div id="logout-modal-overlay"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.50);
            z-index:9999; align-items:center; justify-content:center;">

    <div style="background:#fff; border-radius:14px; width:100%; max-width:420px;
                margin:1rem; box-shadow:0 20px 60px rgba(0,0,0,0.22);
                overflow:hidden; animation: logoutModalIn 0.22s ease;">

        {{-- Header --}}
        <div style="padding:1.25rem 1.75rem; background:#f8fafc;
                    border-bottom:1px solid #e2e8f0;
                    display:flex; align-items:center; gap:0.75rem;">
           
            <h2 style="font-size:1.05rem; font-weight:600; color:#1a2535; margin:0;">
                Sign Out
            </h2>
            <button onclick="hideLogoutModal()"
                    style="margin-left:auto; background:none; border:none;
                           font-size:1.4rem; color:#9aabb8; cursor:pointer;
                           line-height:1; padding:0;" aria-label="Close">×</button>
        </div>

        {{-- Body --}}
        <div style="padding:2rem 1.75rem;">

            <div style="width:72px; height:72px; background:#fef2f2; border-radius:50%;
                        display:flex; align-items:center; justify-content:center;
                        font-size:2rem; margin:0 auto 1.25rem auto;
                        border:2px solid #fecaca;">🔐</div>

            <h3 style="font-size:1.25rem; font-weight:700; color:#1a2535;
                       text-align:center; margin:0 0 0.5rem 0;">Ready to leave?</h3>
            <p style="font-size:0.9rem; color:#7a8999; text-align:center;
                      margin:0 0 1.5rem 0; line-height:1.6;">
                You are about to sign out of your WashDepot staff session.<br>
                Make sure you have completed all pending tasks before continuing.
            </p>

            {{-- Current user pill --}}
            <div style="display:flex; align-items:center; gap:0.85rem;
                        background:#f8fafc; border:1px solid #e2e8f0;
                        border-radius:9px; padding:1rem 1.25rem; margin-bottom:1.75rem;">
                <div style="width:44px; height:44px; border-radius:50%;
                            background:linear-gradient(135deg,#1a2535,#2d4a6e);
                            display:flex; align-items:center; justify-content:center;
                            font-size:0.95rem; font-weight:700; color:white; flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'S', 0, 2)) }}
                </div>
                <div>
                    <div style="font-size:0.95rem; font-weight:700; color:#1a2535;">
                        {{ auth()->user()?->name ?? "Staff's Name" }}
                    </div>
                    <div style="font-size:0.82rem; color:#7a8999;">
                        {{ auth()->user()?->team ?? 'Team A' }} · Staff
                    </div>
                </div>
                <div style="margin-left:auto; text-align:right;">
                    <span style="font-size:0.72rem; color:#9aabb8; display:block;
                                 text-transform:uppercase; letter-spacing:0.05em;
                                 font-weight:600;">Session started</span>
                    <span style="font-size:0.82rem; color:#4a5568; font-weight:600;">
                        {{ now()->format('g:i A') }}
                    </span>
                </div>
            </div>

            {{-- Action buttons --}}
            <div style="display:flex; gap:1rem;">
                <button onclick="hideLogoutModal()"
                        style="flex:1; padding:0.8rem 1.5rem; border-radius:7px;
                               font-weight:600; font-size:0.95rem; cursor:pointer;
                               background:white; color:#1a2535;
                               border:1px solid #d0d9e3; transition:background 0.2s;"
                        onmouseover="this.style.background='#f0f2f5'"
                        onmouseout="this.style.background='white'">
                    Stay Logged In
                </button>

                <a href="{{ url('/login') }}"
                   style="flex:1; display:block; padding:0.8rem 1.5rem; border-radius:7px;
                          font-weight:600; font-size:0.95rem; cursor:pointer;
                          background:#dc2626; color:white; border:none;
                          text-align:center; text-decoration:none; transition:all 0.2s;"
                   onmouseover="this.style.background='#b91c1c'; this.style.boxShadow='0 4px 12px rgba(220,38,38,0.35)'"
                   onmouseout="this.style.background='#dc2626'; this.style.boxShadow='none'">
                    Yes, Sign Out
                </a>
            </div>

        </div>
    </div>
</div>

<style>
@keyframes logoutModalIn {
    from { opacity:0; transform:scale(0.94) translateY(-12px); }
    to   { opacity:1; transform:scale(1)    translateY(0); }
}
</style>

<script>
(function () {
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const hamburger = document.getElementById('hamburger');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('visible');
        hamburger.classList.add('open');
        hamburger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('visible');
        hamburger.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', function () {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 1024) closeSidebar();
        });
    });

    const bell  = document.getElementById('notifBell');
    const panel = document.getElementById('notifPanel');

    bell.addEventListener('click', function (e) {
        e.stopPropagation();
        panel.classList.toggle('open');
    });

    bell.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            panel.classList.toggle('open');
        }
    });

    document.addEventListener('click', function (e) {
        if (!bell.contains(e.target)) panel.classList.remove('open');
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) closeSidebar();
    });

    document.addEventListener('click', function (e) {
        if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
            closeSidebar();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            panel.classList.remove('open');
            hideLogoutModal();
        }
    });
})();

function showLogoutModal() {
    const el = document.getElementById('logout-modal-overlay');
    el.style.display = 'flex';
}

function hideLogoutModal() {
    const el = document.getElementById('logout-modal-overlay');
    el.style.display = 'none';
}

document.getElementById('logout-modal-overlay').addEventListener('click', function (e) {
    if (e.target === this) hideLogoutModal();
});
</script>

@stack('scripts')
</body>
</html>