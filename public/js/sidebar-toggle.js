document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebar-overlay');

    if (!hamburger || !sidebar) return;

    function closeSidebar() {
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
    }

    hamburger.addEventListener('click', function (e) {
        e.stopPropagation(); // prevent immediate close
        sidebar.classList.toggle('open');
        if (overlay) overlay.classList.toggle('active');
    });

    // Click on overlay closes sidebar
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Click anywhere outside sidebar closes it
    document.addEventListener('click', function (e) {
        const isClickInsideSidebar = sidebar.contains(e.target);
        const isClickHamburger = hamburger.contains(e.target);

        if (!isClickInsideSidebar && !isClickHamburger) {
            closeSidebar();
        }
    });
});