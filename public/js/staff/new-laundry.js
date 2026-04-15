// ═══════════════════════════════════════════════════
//  WashDepot — new-laundry.js
//  Place in: public/js/staff/new-laundry.js
// ═══════════════════════════════════════════════════

const BASE_PRICE_PER_KG = 50;
const RUSH_FEE          = 50;

let selectedService = 'ordinary';
let selectedAddons  = [];   // [{ name, price, type }]

// ── Service toggle ───────────────────────────────────
function setService(type) {
    selectedService = type;

    document.getElementById('btn-ordinary').classList.toggle('active', type === 'ordinary');
    document.getElementById('btn-rush').classList.toggle('active', type === 'rush');

    const pickupGroup = document.getElementById('pickup-time-group');
    pickupGroup.style.display = type === 'rush' ? 'block' : 'none';

    recalculate();
}

// ── Addon toggle ─────────────────────────────────────
function toggleAddon(el) {
    el.classList.toggle('selected');
    const name  = el.dataset.name;
    const price = parseFloat(el.dataset.price);
    const type  = el.dataset.type;

    if (el.classList.contains('selected')) {
        selectedAddons.push({ name, price, type });
    } else {
        selectedAddons = selectedAddons.filter(a => a.name !== name);
    }
    recalculate();
}

// ── Recalculate total ────────────────────────────────
function recalculate() {
    const kg        = parseFloat(document.getElementById('kg').value) || 0;
    const base      = kg * BASE_PRICE_PER_KG;
    const rush      = selectedService === 'rush' ? RUSH_FEE : 0;
    const addonSum  = selectedAddons.reduce((s, a) => s + a.price, 0);
    const total     = base + rush + addonSum;

    document.getElementById('base-label').textContent      = `Base Price (${kg} kg × ₱${BASE_PRICE_PER_KG})`;
    document.getElementById('base-price-display').textContent = `₱${base.toFixed(2)}`;

    document.getElementById('rush-row').style.display         = rush ? 'flex' : 'none';
    document.getElementById('rush-fee-display').textContent   = `₱${rush.toFixed(2)}`;

    document.getElementById('addon-row').style.display        = addonSum ? 'flex' : 'none';
    document.getElementById('addon-price-display').textContent = `₱${addonSum.toFixed(2)}`;

    document.getElementById('total-display').textContent      = `₱${total.toFixed(2)}`;
}

// Listen to kg input
document.getElementById('kg').addEventListener('input', recalculate);

// ── Generate Receipt ─────────────────────────────────
async function generateReceipt() {
    const name    = document.getElementById('full_name').value.trim();
    const contact = document.getElementById('contact').value.trim();
    const kg      = parseFloat(document.getElementById('kg').value) || 0;

    if (!name || !contact || kg <= 0) {
        alert('Please fill in all required fields (Name, Contact, Weight).');
        return;
    }

    const addonNames = selectedAddons.map(a => a.name);
    const totalEl    = document.getElementById('total-display').textContent;
    const totalNum   = parseFloat(totalEl.replace('₱', '')) || 0;

    // ── POST to Laravel ──────────────────────────────
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    try {
        const res = await fetch('/staff/laundry', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                customer_name:  name,
                contact_number: contact,
                weight_kg:      kg,
                service_type:   selectedService,
                addons:         addonNames,
                total_price:    totalNum,
            }),
        });

        if (!res.ok) throw new Error('Server error');

        const data = await res.json();

        // ── Populate receipt modal ───────────────────
        document.getElementById('r-name').textContent    = name;
        document.getElementById('r-contact').textContent = contact;
        document.getElementById('r-kg').textContent      = kg + ' kg';
        document.getElementById('r-addons').textContent  = addonNames.length ? addonNames.join(', ') : 'None';
        document.getElementById('r-price').textContent   = `₱${totalNum.toFixed(2)}`;
        document.getElementById('r-qr-code').textContent = data.qr_code;
        document.getElementById('r-queue-num').textContent = String(data.queue_number).padStart(2, '0');

        // QR image via free API
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=${encodeURIComponent(data.qr_code)}`;
        document.getElementById('receipt-qr-img').src = qrUrl;

        document.getElementById('receiptModal').classList.remove('hidden');

    } catch (err) {
        console.error(err);
        alert('Failed to save order. Please try again.');
    }
}

// ── Close receipt ─────────────────────────────────────
function closeReceipt() {
    document.getElementById('receiptModal').classList.add('hidden');
    resetForm();
}

// ── Reset form ────────────────────────────────────────
function resetForm() {
    document.getElementById('full_name').value = '';
    document.getElementById('contact').value   = '';
    document.getElementById('kg').value        = '';

    selectedService = 'ordinary';
    selectedAddons  = [];

    setService('ordinary');

    document.querySelectorAll('.addon-item.selected')
        .forEach(el => el.classList.remove('selected'));

    recalculate();
}