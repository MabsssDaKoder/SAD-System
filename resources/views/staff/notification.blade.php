@extends('staff.staff-layout')

@section('title', 'Notifications')

@section('styles')
<style>
    .main-content {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 0;
        overflow-y: auto;
        background: #f0f2f5;
    }
    .page-header {
        padding: 2rem 2rem 0.5rem 2rem;
        flex-shrink: 0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header-left .page-title {
        font-size: 1.9rem;
        font-weight: 700;
        color: #1a2535;
        margin: 0 0 0.25rem 0;
    }
    .page-header-left .page-subtitle {
        font-size: 0.9rem;
        color: #7a8999;
        margin: 0;
    }
    .header-actions { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }
    .btn {
        padding: 0.6rem 1.25rem;
        border-radius: 7px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-outline { background: white; color: #1a2535; border: 1px solid #d0d9e3; }
    .btn-outline:hover { background: #f0f2f5; }
    .btn-danger-soft { background: white; color: #dc2626; border: 1px solid #fecaca; }
    .btn-danger-soft:hover { background: #fef2f2; }

    .content-wrapper {
        flex: 1;
        padding: 1.5rem 2rem 2rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .filter-bar { display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap; }
    .filter-chip {
        padding: 0.45rem 1rem;
        border-radius: 20px;
        font-size: 0.83rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid #e2e8f0;
        background: white;
        color: #7a8999;
        transition: all 0.18s;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .filter-chip:hover { border-color: #1a2535; color: #1a2535; }
    .filter-chip.active { background: #1a2535; color: white; border-color: #1a2535; }
    .filter-chip .chip-count {
        background: rgba(255,255,255,0.25);
        border-radius: 10px;
        padding: 0 0.4rem;
        font-size: 0.75rem;
        min-width: 18px;
        text-align: center;
    }
    .filter-chip:not(.active) .chip-count { background: #f0f2f5; color: #1a2535; }
    .filter-spacer { flex: 1; }
    .search-wrap { position: relative; }
    .search-wrap::before {
        content: '🔍';
        position: absolute;
        left: 0.75rem; top: 50%;
        transform: translateY(-50%);
        font-size: 0.8rem;
        pointer-events: none;
    }
    .search-wrap input {
        padding: 0.5rem 1rem 0.5rem 2.4rem;
        border: 1px solid #d0d9e3;
        border-radius: 7px;
        font-size: 0.88rem;
        color: #1a2535;
        width: 220px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-wrap input:focus { outline: none; border-color: #1a2535; box-shadow: 0 0 0 3px rgba(26,37,53,0.08); }

    .card { background: #fff; border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; }

    .notif-group-label {
        padding: 0.6rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #9aabb8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        background: #f8fafc;
        border-bottom: 1px solid #f0f2f5;
    }
    .notif-row {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f2f5;
        transition: background 0.15s;
        cursor: pointer;
    }
    .notif-row:last-child { border-bottom: none; }
    .notif-row:hover { background: #f8fafc; }
    .notif-row.unread { background: #f0f5ff; }
    .notif-row.unread:hover { background: #e8f0fe; }
    .unread-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #3b82f6;
        flex-shrink: 0;
        margin-top: 0.55rem;
    }
    .notif-row:not(.unread) .unread-dot { background: transparent; }

    .notif-icon-wrap {
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
    .notif-icon-wrap.blue   { background: #dbeafe; }
    .notif-icon-wrap.green  { background: #dcfce7; }
    .notif-icon-wrap.amber  { background: #fef3c7; }
    .notif-icon-wrap.red    { background: #fee2e2; }
    .notif-icon-wrap.gray   { background: #f1f5f9; }

    .notif-body { flex: 1; min-width: 0; }
    .notif-body h4 {
        font-size: 0.9rem; font-weight: 700; color: #1a2535;
        margin: 0 0 0.2rem 0;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .notif-body p { font-size: 0.83rem; color: #7a8999; margin: 0 0 0.3rem 0; line-height: 1.45; }
    .notif-meta { display: flex; align-items: center; gap: 0.6rem; }
    .notif-time { font-size: 0.77rem; color: #9aabb8; }
    .notif-tag {
        font-size: 0.72rem; font-weight: 600;
        padding: 0.15rem 0.55rem; border-radius: 10px;
    }
    .notif-tag.order  { background: #dbeafe; color: #1d4ed8; }
    .notif-tag.alert  { background: #fee2e2; color: #b91c1c; }
    .notif-tag.system { background: #f1f5f9; color: #475569; }

    .notif-actions {
        display: flex; gap: 0.4rem; align-items: center;
        flex-shrink: 0; opacity: 0; transition: opacity 0.15s;
    }
    .notif-row:hover .notif-actions { opacity: 1; }
    .notif-action-btn {
        width: 30px; height: 30px;
        border-radius: 6px; border: 1px solid #e2e8f0;
        background: white; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; transition: all 0.15s;
    }
    .notif-action-btn:hover { background: #f0f2f5; border-color: #1a2535; }

    .summary-strip { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .summary-card {
        background: white; border: 1px solid #e2e8f0;
        border-radius: 10px; padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: 0.85rem;
    }
    .summary-icon {
        width: 40px; height: 40px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .s-label { font-size: 0.78rem; color: #9aabb8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
    .s-value { font-size: 1.4rem; font-weight: 700; color: #1a2535; line-height: 1.1; }

    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-state .empty-icon { font-size: 3rem; margin-bottom: 1rem; display: block; }
    .empty-state h3 { font-size: 1.1rem; font-weight: 700; color: #1a2535; margin: 0 0 0.4rem 0; }
    .empty-state p { font-size: 0.88rem; color: #7a8999; margin: 0; }

    @media (max-width: 768px) {
        .content-wrapper { padding: 1rem; }
        .page-header { padding: 1.25rem 1rem 0.5rem 1rem; }
        .summary-strip { grid-template-columns: 1fr 1fr 1fr; }
        .search-wrap input { width: 150px; }
    }
    @media (max-width: 500px) {
        .summary-strip { grid-template-columns: 1fr 1fr; }
        .search-wrap { display: none; }
    }
</style>
@endsection

@section('content')
<div class="main-content">

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Notifications</h1>
            <p class="page-subtitle">Your assigned orders, alerts, and updates</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-outline" onclick="markAllRead()">✓ Mark All as Read</button>
            <button class="btn btn-danger-soft" onclick="clearAll()">🗑 Clear All</button>
        </div>
    </div>

    <div class="content-wrapper">

        {{-- ── SUMMARY ── --}}
        <div class="summary-strip">
            <div class="summary-card">
                <div class="summary-icon" style="background:#dbeafe;">🔔</div>
                <div>
                    <div class="s-label">Total</div>
                    <div class="s-value" id="count-total">8</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon" style="background:#fee2e2;">🔴</div>
                <div>
                    <div class="s-label">Unread</div>
                    <div class="s-value" id="count-unread">3</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon" style="background:#fef3c7;">⚠️</div>
                <div>
                    <div class="s-label">Alerts</div>
                    <div class="s-value" id="count-alerts">1</div>
                </div>
            </div>
        </div>

        {{-- ── FILTER BAR ── --}}
        <div class="filter-bar">
            <button class="filter-chip active" data-filter="all" onclick="setFilter(this,'all')">
                All <span class="chip-count">8</span>
            </button>
            <button class="filter-chip" data-filter="unread" onclick="setFilter(this,'unread')">
                Unread <span class="chip-count">3</span>
            </button>
            <button class="filter-chip" data-filter="order" onclick="setFilter(this,'order')">
                Orders <span class="chip-count">6</span>
            </button>
            <button class="filter-chip" data-filter="alert" onclick="setFilter(this,'alert')">
                Alerts <span class="chip-count">1</span>
            </button>
            <button class="filter-chip" data-filter="system" onclick="setFilter(this,'system')">
                System <span class="chip-count">1</span>
            </button>
            <div class="filter-spacer"></div>
            <div class="search-wrap">
                <input type="text" placeholder="Search notifications..." oninput="searchNotifs(this.value)">
            </div>
        </div>

        {{-- ── NOTIFICATION LIST ── --}}
        <div class="card" id="notif-container">

            <div class="notif-group-label">Today</div>

            <div class="notif-row unread" data-category="order">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap blue">🧺</div>
                <div class="notif-body">
                    <h4>New Order Assigned — #1048</h4>
                    <p>Order #1048 has been assigned to your team. Customer: Maria Santos. Service: Wash & Fold (8 kg).</p>
                    <div class="notif-meta">
                        <span class="notif-time">5 minutes ago</span>
                        <span class="notif-tag order">Order</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Mark as read" onclick="markRead(this, event)">✓</button>
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="notif-row unread" data-category="alert">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap amber">⚠️</div>
                <div class="notif-body">
                    <h4>Low Stock: Fabric Conditioner</h4>
                    <p>Fabric Conditioner is running low (3 units left). Please notify your admin to restock.</p>
                    <div class="notif-meta">
                        <span class="notif-time">30 minutes ago</span>
                        <span class="notif-tag alert">Alert</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Mark as read" onclick="markRead(this, event)">✓</button>
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="notif-row unread" data-category="order">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap green">✅</div>
                <div class="notif-body">
                    <h4>Order #1045 Marked Complete</h4>
                    <p>You successfully completed order #1045 for Juan dela Cruz.</p>
                    <div class="notif-meta">
                        <span class="notif-time">1 hour ago</span>
                        <span class="notif-tag order">Order</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Mark as read" onclick="markRead(this, event)">✓</button>
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="notif-group-label">Yesterday</div>

            <div class="notif-row" data-category="order">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap green">✅</div>
                <div class="notif-body">
                    <h4>Order #1042 Completed</h4>
                    <p>Order #1042 for Ana Reyes was marked complete. Payment collected: ₱180.</p>
                    <div class="notif-meta">
                        <span class="notif-time">Yesterday, 5:42 PM</span>
                        <span class="notif-tag order">Order</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="notif-row" data-category="order">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap blue">🔄</div>
                <div class="notif-body">
                    <h4>Order #1041 Moved to Processing</h4>
                    <p>You updated order #1041 from Pending to Processing.</p>
                    <div class="notif-meta">
                        <span class="notif-time">Yesterday, 2:00 PM</span>
                        <span class="notif-tag order">Order</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="notif-row" data-category="system">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap gray">⚙️</div>
                <div class="notif-body">
                    <h4>Pricing Updated by Admin</h4>
                    <p>Admin updated the rate for "Wash & Fold" to ₱60/kg. This applies to all new orders.</p>
                    <div class="notif-meta">
                        <span class="notif-time">Yesterday, 9:15 AM</span>
                        <span class="notif-tag system">System</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="notif-group-label">Earlier This Week</div>

            <div class="notif-row" data-category="order">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap blue">🧺</div>
                <div class="notif-body">
                    <h4>New Order Assigned — #1038</h4>
                    <p>Order #1038 assigned to your team. Customer: Rosa Villanueva. Service: Wash & Iron (6 kg).</p>
                    <div class="notif-meta">
                        <span class="notif-time">Mon, 11:30 AM</span>
                        <span class="notif-tag order">Order</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="notif-row" data-category="order">
                <div class="unread-dot"></div>
                <div class="notif-icon-wrap green">✅</div>
                <div class="notif-body">
                    <h4>Order #1036 Completed</h4>
                    <p>Order #1036 for Pedro Bautista marked complete. Service: Dry Clean.</p>
                    <div class="notif-meta">
                        <span class="notif-time">Sun, 3:45 PM</span>
                        <span class="notif-tag order">Order</span>
                    </div>
                </div>
                <div class="notif-actions">
                    <button class="notif-action-btn" title="Dismiss" onclick="dismiss(this, event)">✕</button>
                </div>
            </div>

            <div class="empty-state" id="empty-state" style="display:none;">
                <span class="empty-icon">🔔</span>
                <h3>No notifications found</h3>
                <p>Try adjusting your filter or search query.</p>
            </div>

        </div>
    </div>
</div>

<script>
    function setFilter(el, filter) {
        document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        applyFilters(filter, document.querySelector('.search-wrap input').value);
    }

    function searchNotifs(query) {
        const activeFilter = document.querySelector('.filter-chip.active')?.dataset.filter || 'all';
        applyFilters(activeFilter, query);
    }

    function applyFilters(filter, query) {
        const rows = document.querySelectorAll('.notif-row');
        const q = query.toLowerCase();
        let visible = 0;

        rows.forEach(row => {
            const cat      = row.dataset.category || '';
            const isUnread = row.classList.contains('unread');
            const text     = row.textContent.toLowerCase();

            const matchFilter =
                filter === 'all'    ? true :
                filter === 'unread' ? isUnread :
                cat === filter;

            const matchSearch = !q || text.includes(q);

            if (matchFilter && matchSearch) { row.style.display = ''; visible++; }
            else row.style.display = 'none';
        });

        document.querySelectorAll('.notif-group-label').forEach(label => {
            let sibling = label.nextElementSibling;
            let hasVisible = false;
            while (sibling && !sibling.classList.contains('notif-group-label') && !sibling.id) {
                if (sibling.style.display !== 'none' && sibling.classList.contains('notif-row')) hasVisible = true;
                sibling = sibling.nextElementSibling;
            }
            label.style.display = hasVisible ? '' : 'none';
        });

        document.getElementById('empty-state').style.display = visible === 0 ? 'block' : 'none';
    }

    function markRead(btn, e) {
        e.stopPropagation();
        const row = btn.closest('.notif-row');
        row.classList.remove('unread');
        row.querySelector('.unread-dot').style.background = 'transparent';
        updateCounts();
    }

    function dismiss(btn, e) {
        e.stopPropagation();
        const row = btn.closest('.notif-row');
        row.style.transition = 'opacity 0.25s, max-height 0.3s';
        row.style.opacity = '0';
        row.style.maxHeight = row.offsetHeight + 'px';
        setTimeout(() => { row.style.maxHeight = '0'; row.style.padding = '0'; row.style.border = 'none'; }, 50);
        setTimeout(() => { row.remove(); updateCounts(); checkEmpty(); }, 350);
    }

    function markAllRead() {
        document.querySelectorAll('.notif-row.unread').forEach(row => {
            row.classList.remove('unread');
            row.querySelector('.unread-dot').style.background = 'transparent';
        });
        updateCounts();
    }

    function clearAll() {
        if (!confirm('Clear all notifications? This cannot be undone.')) return;
        document.querySelectorAll('.notif-row').forEach(r => r.remove());
        document.querySelectorAll('.notif-group-label').forEach(l => l.remove());
        updateCounts();
        document.getElementById('empty-state').style.display = 'block';
    }

    function updateCounts() {
        const rows   = document.querySelectorAll('.notif-row');
        const unread = document.querySelectorAll('.notif-row.unread');
        const alerts = document.querySelectorAll('.notif-row[data-category="alert"]');
        document.getElementById('count-total').textContent  = rows.length;
        document.getElementById('count-unread').textContent = unread.length;
        document.getElementById('count-alerts').textContent = alerts.length;
    }

    function checkEmpty() {
        document.getElementById('empty-state').style.display =
            document.querySelectorAll('.notif-row').length === 0 ? 'block' : 'none';
    }
</script>
@endsection