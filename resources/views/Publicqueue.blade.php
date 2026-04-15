<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WashDepot — Laundry Queue</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/publicqueue.css') }}">
</head>
<body>

    {{-- HERO --}}
    <header class="hero">
        <img src="https://images.unsplash.com/photo-1545173168-9f1947eebb7f?w=1400&q=80&auto=format&fit=crop"
             alt="Laundry machines" class="hero-bg">
        <div class="hero-overlay">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="hero-logo">🧺</div>
            <h1 class="hero-title">Wash<span>Depot</span></h1>
            <p class="hero-sub">Laundry Queue Management</p>
        </div>
    </header>

    {{-- STATS BAR --}}
    <div class="stats-bar">
        <div class="stat-chip">
            <span class="stat-dot" style="background:var(--pending)"></span>
            Pending <span class="stat-count" id="stat-pending">0</span>
        </div>
        <div class="stat-chip">
            <span class="stat-dot" style="background:var(--processing)"></span>
            Processing <span class="stat-count" id="stat-processing">0</span>
        </div>
        <div class="stat-chip">
            <span class="stat-dot" style="background:var(--complete)"></span>
            Complete <span class="stat-count" id="stat-complete">0</span>
        </div>
        <div class="stat-chip">
            <span class="stat-dot" style="background:var(--rush)"></span>
            Rush Orders <span class="stat-count" id="stat-rush">0</span>
        </div>
    </div>

    {{-- MAIN TABLE --}}
    <main class="container">
        <div class="section-header">
            <h2 class="section-title">Customer Queue</h2>
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input class="search-input" type="text"
                       placeholder="Search customer..."
                       oninput="filterTable(this.value)">
            </div>
        </div>

        <div class="table-card">
            <table id="queueTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Service Type</th>
                        <th>Received</th>
                        <th>Est. Finish</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="queue-tbody">
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:#5b7a8a;">
                            Loading queue...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} <span>WashDepot</span> · Powered by Laravel
        <span id="last-updated" style="margin-left:12px; font-size:0.72rem; opacity:0.6;"></span>
    </footer>

    <script>
        // ── Auto-refresh every 5 seconds ───────────────────
        document.addEventListener('DOMContentLoaded', () => {
            fetchQueue();
            setInterval(fetchQueue, 5000);
        });

        async function fetchQueue() {
            try {
                const res  = await fetch('/queue/json');
                const data = await res.json();
                renderStats(data.stats);
                renderTable(data.customers);
                document.getElementById('last-updated').textContent =
                    'Last updated: ' + new Date().toLocaleTimeString();
            } catch (err) {
                console.error('Failed to fetch queue:', err);
            }
        }

        // ── Render stats bar ────────────────────────────────
        function renderStats(stats) {
            document.getElementById('stat-pending').textContent    = stats.pending    ?? 0;
            document.getElementById('stat-processing').textContent = stats.processing ?? 0;
            document.getElementById('stat-complete').textContent   = stats.complete   ?? 0;
            document.getElementById('stat-rush').textContent       = stats.rush       ?? 0;
        }

        // ── Render table rows ───────────────────────────────
        function renderTable(customers) {
            const tbody = document.getElementById('queue-tbody');

            if (!customers.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round"
                                          d="M9 17v-2a4 4 0 014-4h0a4 4 0 014 4v2M3 17v-1a4 4 0 014-4h0"/>
                                </svg>
                                <p>No customers in queue right now.</p>
                            </div>
                        </td>
                    </tr>`;
                return;
            }

            tbody.innerHTML = customers.map(row => `
                <tr>
                    <td><span class="queue-badge">${row.queue}</span></td>
                    <td>
                        <div class="customer-name">${escHtml(row.name)}</div>
                        <div class="customer-items">${escHtml(row.items)}</div>
                    </td>
                    <td>
                        ${row.type === 'rush'
                            ? '<span class="service-tag service-rush">⚡ Rush</span>'
                            : '<span class="service-tag service-ordinary">🕐 Ordinary</span>'}
                    </td>
                    <td class="time-cell"><strong>${row.received}</strong></td>
                    <td class="time-cell">${row.finish}</td>
                    <td>${statusPill(row.status)}</td>
                </tr>
            `).join('');
        }

        // ── Status pill HTML ─────────────────────────────────
        function statusPill(status) {
            const map = {
                pending:    '<span class="status-pill status-pending"><span class="status-dot"></span> Pending</span>',
                processing: '<span class="status-pill status-processing"><span class="status-dot"></span> Processing</span>',
                complete:   '<span class="status-pill status-complete"><span class="status-dot"></span> Complete</span>',
            };
            return map[status] ?? status;
        }

        // ── Search filter ────────────────────────────────────
        function filterTable(val) {
            const rows = document.querySelectorAll('#queueTable tbody tr');
            const q    = val.toLowerCase();
            rows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }

        // ── Escape HTML to prevent XSS ───────────────────────
        function escHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }
    </script>

</body>
</html>