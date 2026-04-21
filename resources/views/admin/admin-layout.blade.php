<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — WashDepot</title>

    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/admin-layout.css') }}">
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
                    <img src="{{ asset('img/logoWashDepot.png') }}" alt="WashDepot"
                         onerror="this.style.display='none'">
                </div>
                <div class="brand-text">
                    <span class="brand-name">WashDepot</span>
                    <span class="brand-role">Admin / Owner</span>
                </div>
            </div>  

            {{-- Nav --}}
            <nav class="sidebar-nav">
                <a href="{{ url('/admin/shop-management') }}"
                   class="{{ request()->is('admin/shop-management') ? 'active' : '' }}">
                    Shop Management
                </a>
                 <a href="{{ url('/admin/branch-management') }}"
                   class="{{ request()->is('admin/branch-management') ? 'active' : '' }}">
                    Branch Management
                </a>
                <a href="{{ url('/admin/update-template') }}"
                   class="{{ request()->is('admin/update-template') ? 'active' : '' }}">
                    Update Template
                </a>
                <a href="{{ url('/admin/inventory') }}"
                   class="{{ request()->is('admin/inventory*') ? 'active' : '' }}">
                    Inventory Management
                </a>
                <a href="{{ url('/admin/reports') }}"
                   class="{{ request()->is('admin/reports') ? 'active' : '' }}">
                    Reports / Sales
                </a>
                <a href="{{ url('/admin/account-management') }}"
                   class="{{ request()->is('admin/account-management') ? 'active' : '' }}">
                    Account Management
                </a>
                 <a href="{{ url('/admin/new-laundry') }}"
                   class="{{ request()->is('admin/new-laundry') ? 'active' : '' }}">
                    New Laundry 
                </a>
                <a href="{{ url('/admin/queue') }}"
                   class="{{ request()->is('admin/queue') ? 'active' : '' }}">
                    Queue Status
                </a>
            </nav>
        </div>

        {{-- Bottom links --}}
        <div class="sidebar-bottom">
            <a href="{{ url('/admin/profile') }}"
               class="{{ request()->is('admin/profile') ? 'active' : '' }}">
                Profile
            </a>
            <a href="{{ url('/admin/help') }}"
               class="{{ request()->is('admin/help') ? 'active' : '' }}">
                Help &amp; Support
            </a>
        
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

                    {{-- Badge: show only when count > 0 --}}
                    @php $unreadCount = auth()->user()?->unreadNotifications?->count() ?? 0; @endphp
                   
                    {{-- Dropdown panel --}}
                    <div class="notif-panel" id="notifPanel">
                        <div class="notif-panel-header">Notifications</div>
                        <div class="notif-list" id="notifList">
                            {{--
                                Wire up with real notifications:
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
                            {{-- Placeholder (remove once wired) --}}
                            <div class="notif-empty">No notifications yet</div>
                        </div>
                        <div class="notif-panel-footer">
                            <a href="{{ url('/admin/notifications') }}">View all</a>
                        </div>
                    </div>
                </div>
                {{-- /Bell --}}

                {{-- Admin info --}}
                <div class="staff-info">
                    <span class="staff-name">{{ auth()->user()?->name ?? "Admin's Name" }}</span>
                    <span class="staff-team">Admin / Owner</span>
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
     JS — Sidebar toggle + Notif panel
══════════════════════════════════════ --}}
<script>
(function () {
    /* ── Sidebar ── */
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
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

    /* Close sidebar when a nav link is tapped on mobile */
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

    /* Close panel on Escape */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') panel.classList.remove('open');
    });

    /* ── Auto-close sidebar when resizing to desktop ── */
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) closeSidebar();
    });
    
})();
document.addEventListener('click', function (e) {
    const clickedInsideSidebar = sidebar.contains(e.target);
    const clickedHamburger = hamburger.contains(e.target);

    if (!clickedInsideSidebar && !clickedHamburger) {
        closeSidebar();
    }
});
</script>
scr
@stack('scripts')
</body>
</html>