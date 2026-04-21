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

    {{-- ── Sidebar Backdrop (mobile / tablet) ── --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- ══════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════ --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-top">
            {{-- Brand --}}
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

            {{-- Nav --}}
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

        {{-- Bottom links --}}
        <div class="sidebar-bottom">
            <a href="{{ url('/staff/profile') }}"
               class="{{ request()->is('staff/profile') ? 'active' : '' }}">
                Profile
            </a>
            <a href="{{ url('/staff/help') }}"
               class="{{ request()->is('staff/help') ? 'active' : '' }}">
                Help &amp; Support
            </a>
        
                    <span class="sidebar-bottom logout-btn">Logout</span>
               
        </div>
    </aside>

    {{-- ══════════════════════════════════════
         MAIN WRAPPER
    ══════════════════════════════════════ --}}
    <div class="main-wrapper">

        {{-- ── Top Bar ── --}}
        <div class="topbar">

            {{-- Hamburger (mobile / tablet only) --}}
            <button class="hamburger" id="hamburger"
                    aria-label="Open menu" aria-expanded="false" aria-controls="sidebar">
                <span></span>
                <span></span>
                <span></span>
            </button>

            {{-- Right section --}}
            <div class="topbar-right">

                {{-- Notification Bell --}}
                <div class="notif-bell" id="notifBell" style="position:relative;" role="button"
                     aria-label="Notifications" tabindex="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                         fill="white" viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6V11
                                 c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5
                                 s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2
                                 2v1h16v-1l-2-2z"/>
                    </svg>

                    {{-- Badge --}}
                    @php $unreadCount = auth()->user()?->unreadNotifications?->count() ?? 0; @endphp
                    <!-- <span class="notif-count" id="notifCount">
                        {{ $unreadCount > 0 ? ($unreadCount > 99 ? '99+' : $unreadCount) : '' }}
                    </span> -->

                    {{-- Dropdown panel --}}
                    <div class="notif-panel" id="notifPanel">
                        <div class="notif-panel-header">Notifications</div>
                        <div class="notif-list" id="notifList">
                            {{--
                                @forelse(auth()->user()->unreadNotifications->take(10) as $n)
                                    <div class="notif-item">
                                        <div>
                                            <div>{{ $n->data['message'] }}</div>
                                            <div class="notif-time">
                                                {{ $n->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="notif-empty">No new notifications</div>
                                @endforelse
                            --}}
                            <div class="notif-empty">No notifications yet</div>
                        </div>
                        <div class="notif-panel-footer">
                            <a href="{{ url('/staff/notifications') }}">View all</a>
                        </div>
                    </div>
                </div>
                {{-- /Bell --}}

                {{-- Staff info --}}
                <div class="staff-info">
                    <span class="staff-name">{{ auth()->user()?->name ?? "Staff's Name" }}</span>
                    <span class="staff-team">{{ auth()->user()?->team ?? 'Team A' }}</span>
                </div>

            </div>
        </div>
        {{-- /Topbar --}}

        {{-- ── Page Content ── --}}
        <div class="main-content">
            @yield('content')
        </div>

    </div>
    {{-- /Main wrapper --}}

</div>
{{-- /App container --}}

{{-- ══════════════════════════════════════
     JS — identical pattern for both layouts
══════════════════════════════════════ --}}
<script>
(function () {
    /* ── Sidebar ── */
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

    /* ── Notification Bell ── */
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

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') panel.classList.remove('open');
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) closeSidebar();
    });
})();
</script>

@stack('scripts')
</body>
</html>