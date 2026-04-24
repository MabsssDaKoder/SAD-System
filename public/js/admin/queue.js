// ═══════════════════════════════════════════════════
//  WashDepot — queue.js  (Staff Kanban Board)
//  Place in: public/js/staff/queue.js
// ═══════════════════════════════════════════════════

let pendingSMS = null;   // order awaiting SMS confirmation

// ── Bootstrap ────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    fetchOrders();
    setInterval(fetchOrders, 5000);   // auto-refresh every 5 s
});

// ── Fetch orders from server ─────────────────────────
async function fetchOrders() {
    try {
        const res  = await fetch('/staff/queue/json');
        const data = await res.json();
        renderBoard(data);
    } catch (err) {
        console.error('Queue fetch failed:', err);
    }
}

// ── Cancel a pending order ────────────────────────────
async function cancelService(id) {
    if (!confirm('Cancel this order? This cannot be undone.')) return;

    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    try {
        await fetch(`/staff/laundry/${id}/cancel`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
        });
        fetchOrders();   // immediate refresh
    } catch (err) {
        console.error('Cancel failed:', err);
    }
}

// ── Render all three columns ─────────────────────────
function renderBoard(orders) {
    const columns = { pending: [], processing: [], complete: [] };

    orders.forEach(o => {
        if (columns[o.status]) columns[o.status].push(o);
    });

    document.getElementById('pending-count').textContent    = columns.pending.length;
    document.getElementById('processing-count').textContent = columns.processing.length;
    document.getElementById('complete-count').textContent   = columns.complete.length;

    renderColumn('pending-list',    columns.pending);
    renderColumn('processing-list', columns.processing);
    renderColumn('complete-list',   columns.complete);
}

// ── Render one column ─────────────────────────────────
function renderColumn(containerId, orders) {
    const el = document.getElementById(containerId);

    if (!orders.length) {
        el.innerHTML = '<div class="empty-col">No orders</div>';
        return;
    }

    el.innerHTML = orders.map(o => cardHTML(o)).join('');
}

// ── Build card HTML ───────────────────────────────────
function cardHTML(o) {
    const rushTag = o.type === 'rush'
        ? '<span class="card-rush-tag">⚡ Rush</span>'
        : '<span class="card-ordinary-tag">🕐 Ordinary</span>';

    const addonsText = o.addons.length ? o.addons.join(', ') : 'None';

    const actionBtns = actionsFor(o);

    return `
    <div class="queue-card" data-id="${o.id}">
        <div class="card-top">
            <span class="card-queue">#${String(o.queue).padStart(2,'0')}</span>
            ${rushTag}
        </div>
        <div class="card-name">${o.name}</div>
        <div class="card-detail">📞 ${o.contact}</div>
        <div class="card-detail">⚖️ ${o.kg} kg</div>
        <div class="card-detail">🧴 ${addonsText}</div>
        <div class="card-detail">🕐 ${o.received}</div>
        <div class="card-detail">🏁 ${o.finish}</div>
        <div class="card-price">₱${o.total}</div>
        <div class="card-actions">${actionBtns}</div>
    </div>`;
}

// ── Action buttons per status ─────────────────────────
function actionsFor(o) {
    if (o.status === 'pending') {
        return `
            <button class="btn-action btn-process"
                onclick="updateStatus(${o.id}, 'processing')">
                ▶ Start Processing
            </button>
            <button class="btn-cancel"
                onclick="cancelService(${o.id})">
                ✕ Cancel
            </button>`;
    }
    if (o.status === 'processing') {
        return `
            <button class="btn-action btn-complete"
                onclick="updateStatus(${o.id}, 'complete')">
                ✔ Mark Complete
            </button>`;
    }
    if (o.status === 'complete') {
        return `
            <button class="btn-action btn-sms"
                onclick="openSMS(${o.id}, '${o.contact}', '${o.name}')">
                📱 SMS Customer
            </button>`;
    }
    return '';
}

// ── Update order status ───────────────────────────────
async function updateStatus(id, status) {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    try {
        await fetch(`/staff/laundry/${id}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify({ status }),
        });
        fetchOrders();   // immediate refresh
    } catch (err) {
        console.error('Status update failed:', err);
    }
}

// ── SMS Modal ─────────────────────────────────────────
function openSMS(id, contact, name) {
    pendingSMS = { id, contact, name };
    document.getElementById('sms-contact').textContent = contact;
    document.getElementById('smsModal').classList.remove('hidden');
}

function closeSMS() {
    pendingSMS = null;
    document.getElementById('smsModal').classList.add('hidden');
}

function confirmSMS() {
    // Wire up your actual SMS API (e.g. Semaphore, Vonage) here.
    // For now we just show the success modal.
    closeSMS();
    document.getElementById('smsSentModal').classList.remove('hidden');
}

function closeSMSSent() {
    document.getElementById('smsSentModal').classList.add('hidden');
}