// Enable form when Add or Edit is clicked
function enableForm(mode) {
    // Enable inputs
    document.getElementById('addon_name').disabled  = false;
    document.getElementById('addon_price').disabled = false;
    document.getElementById('cat_soap').disabled        = false;
    document.getElementById('cat_conditioner').disabled = false;

    // Enable Save and Cancel
    document.getElementById('saveAddonBtn').disabled   = false;
    document.getElementById('cancelAddonBtn').disabled = false;

    // Clear fields if Add mode
    if (mode === 'add') {
        document.getElementById('addon_name').value  = '';
        document.getElementById('addon_price').value = '';
    }
}

// Disable form
function disableForm() {
    document.getElementById('addon_name').disabled  = true;
    document.getElementById('addon_price').disabled = true;
    document.getElementById('cat_soap').disabled        = true;
    document.getElementById('cat_conditioner').disabled = true;
    document.getElementById('saveAddonBtn').disabled   = true;
    document.getElementById('cancelAddonBtn').disabled = true;

    // Clear fields
    document.getElementById('addon_name').value  = '';
    document.getElementById('addon_price').value = '';
}

// Save addon (UI only for now)
function saveAddon() {
    const name     = document.getElementById('addon_name').value.trim();
    const price    = document.getElementById('addon_price').value;
    const category = document.querySelector('.cat-btn.active').textContent;

    if (!name || !price) {
        alert('Please fill in all fields!');
        return;
    }

    // Add to the correct card
    const item = document.createElement('div');
    item.className = 'addon-item';
    item.innerHTML = `
        <span>${name}</span>
        <small>₱${price} per pack</small>
    `;

    if (category === 'Powdered Detergent') {
        document.getElementById('det-list').appendChild(item);
    } else {
        document.getElementById('conditioner-list').appendChild(item);
    }

    disableForm();
}

// Category toggle
document.getElementById('cat_soap').addEventListener('click', function() {
    document.getElementById('cat_soap').classList.add('active');
    document.getElementById('cat_conditioner').classList.remove('active');
});

document.getElementById('cat_conditioner').addEventListener('click', function() {
    document.getElementById('cat_conditioner').classList.add('active');
    document.getElementById('cat_soap').classList.remove('active');
});

// ════════════════════════════════════════════════
// BRANCH SELECTION
// ════════════════════════════════════════════════
function onBranchChange(value) {
    // Hook into your backend logic here to load branch-specific add-ons
    console.log('Branch selected:', value);
}

// ════════════════════════════════════════════════
// SERVICE TYPE MANAGEMENT
// ════════════════════════════════════════════════
let currentEditingChip = null;

function addServiceType() {
    const name = document.getElementById('service_name').value.trim();
    const price = document.getElementById('service_price').value;

    if (!name || !price) {
        alert('Please fill in all fields');
        return;
    }

    const chip = document.createElement('div');
    chip.className = 'service-chip';
    chip.innerHTML = `
        <div class="service-chip-content">
            <span>${name} (₱${parseFloat(price).toFixed(2)})</span>
            <div class="service-chip-menu">
                <button class="service-chip-btn" onclick="editService(this)">✎</button>
                <button class="service-chip-btn" onclick="deleteService(this)">✕</button>
            </div>
        </div>
    `;

    document.querySelector('.service-type-chips').appendChild(chip);

    document.getElementById('service_name').value = '';
    document.getElementById('service_price').value = '';
}

function editService(btn) {
    const chip = btn.closest('.service-chip');
    const text = chip.querySelector('span').textContent;

    const match = text.match(/^(.*?)\s*\(₱([\d.]+)\)$/);
    if (match) {
        document.getElementById('modal_service_name').value = match[1];
        document.getElementById('modal_service_price').value = match[2];
    }

    currentEditingChip = chip;
    document.getElementById('editServiceModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editServiceModal').classList.remove('active');
    currentEditingChip = null;
}

function updateService() {
    const name = document.getElementById('modal_service_name').value.trim();
    const price = document.getElementById('modal_service_price').value;

    if (!name || !price) {
        alert('Please fill in all fields');
        return;
    }

    if (currentEditingChip) {
        currentEditingChip.querySelector('span').textContent = `${name} (₱${parseFloat(price).toFixed(2)})`;
    }

    closeEditModal();
}

function deleteService(btn) {
    if (confirm('Are you sure you want to delete this service?')) {
        btn.closest('.service-chip').remove();
    }
}

// ════════════════════════════════════════════════
// ADD-ON MANAGEMENT
// ════════════════════════════════════════════════
let currentEditingItem = null;
let addonMode = 'add'; // 'add' | 'edit'

function newAddonForm() {
    // Clear the form and reset to add mode
    document.getElementById('addon_name').value = '';
    document.getElementById('addon_price').value = '';
    document.getElementById('addon_scoops').value = '';
    currentEditingItem = null;
    addonMode = 'add';

    // Reset category buttons
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('.cat-btn[data-category="powdered"]').classList.add('active');

    // Show Add/Edit, hide Confirm/Cancel
    document.getElementById('confirmAddonBtn').style.display = 'none';
    document.getElementById('cancelAddonBtn').style.display = 'none';
}

function addNewAddon() {
    const name = document.getElementById('addon_name').value.trim();
    const price = document.getElementById('addon_price').value;
    const scoops = document.getElementById('addon_scoops').value;
    const category = document.querySelector('.cat-btn.active')?.dataset.category || 'powdered';

    if (!name || !price || !scoops) {
        alert('Please fill in all fields');
        return;
    }

    const categoryMap = {
        'powdered': 'powdered-list',
        'liquid': 'liquid-list',
        'conditioner': 'conditioner-list'
    };

    const item = document.createElement('div');
    item.className = 'addon-item';
    item.innerHTML = `
        <div class="addon-item-content">
            <span class="addon-item-name">${name}</span>
            <div class="addon-item-details">₱${parseFloat(price).toFixed(2)} per packs | ₱${parseFloat(scoops).toFixed(2)} per scoops</div>
        </div>
        <div class="addon-item-actions">
            <button class="addon-item-btn edit" onclick="editAddonInline(this)">✎</button>
            <button class="addon-item-btn delete" onclick="deleteAddon(this)">✕</button>
        </div>
    `;

    document.getElementById(categoryMap[category]).appendChild(item);

    // Reset form
    document.getElementById('addon_name').value = '';
    document.getElementById('addon_price').value = '';
    document.getElementById('addon_scoops').value = '';
}

function editAddonInline(btn) {
    const item = btn.closest('.addon-item');
    const content = item.querySelector('.addon-item-content');
    const name = content.querySelector('.addon-item-name').textContent;
    const details = content.querySelector('.addon-item-details').textContent;

    const match = details.match(/₱([\d.]+)\s*per packs\s*\|\s*₱([\d.]+)\s*per scoops/);
    if (match) {
        document.getElementById('modal_addon_name').value = name;
        document.getElementById('modal_addon_price').value = match[1];
        document.getElementById('modal_addon_scoops').value = match[2];
    }

    currentEditingItem = item;
    document.getElementById('editAddonModal').classList.add('active');
}

function editAddonStart() {
    // Populate form from selected item if one is highlighted, otherwise prompt
    if (currentEditingItem) {
        const content = currentEditingItem.querySelector('.addon-item-content');
        const name = content.querySelector('.addon-item-name').textContent;
        const details = content.querySelector('.addon-item-details').textContent;

        const match = details.match(/₱([\d.]+)\s*per packs\s*\|\s*₱([\d.]+)\s*per scoops/);
        if (match) {
            document.getElementById('addon_name').value = name;
            document.getElementById('addon_price').value = match[1];
            document.getElementById('addon_scoops').value = match[2];
        }

        addonMode = 'edit';
        // Show Confirm/Cancel, keep Add/Edit visible
        document.getElementById('confirmAddonBtn').style.display = '';
        document.getElementById('cancelAddonBtn').style.display = '';
    } else {
        alert('Please click the ✎ button on an item in the list to edit it.');
    }
}

function deleteAddon(btn) {
    if (confirm('Delete this add-on?')) {
        const item = btn.closest('.addon-item');
        if (currentEditingItem === item) {
            cancelEditAddon();
        }
        item.remove();
    }
}

function saveEditAddon() {
    if (!currentEditingItem) return;

    const name = document.getElementById('modal_addon_name').value.trim() ||
                 document.getElementById('addon_name').value.trim();
    const price = document.getElementById('modal_addon_price').value ||
                  document.getElementById('addon_price').value;
    const scoops = document.getElementById('modal_addon_scoops').value ||
                   document.getElementById('addon_scoops').value;

    if (!name || !price || !scoops) {
        alert('Please fill in all fields');
        return;
    }

    const content = currentEditingItem.querySelector('.addon-item-content');
    content.querySelector('.addon-item-name').textContent = name;
    content.querySelector('.addon-item-details').textContent =
        `₱${parseFloat(price).toFixed(2)} per packs | ₱${parseFloat(scoops).toFixed(2)} per scoops`;

    cancelEditAddon();
}

function cancelEditAddon() {
    document.getElementById('editAddonModal').classList.remove('active');
    currentEditingItem = null;
    addonMode = 'add';

    // Clear modal fields
    document.getElementById('modal_addon_name').value = '';
    document.getElementById('modal_addon_price').value = '';
    document.getElementById('modal_addon_scoops').value = '';

    // Hide Confirm/Cancel in the form card
    document.getElementById('confirmAddonBtn').style.display = 'none';
    document.getElementById('cancelAddonBtn').style.display = 'none';
}

// ════════════════════════════════════════════════
// INIT
// ════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', function() {
    // Category button toggle
    document.querySelectorAll('.cat-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.closest('.category-buttons');
            if (parent) {
                parent.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Allow clicking an addon item to select it for editing
    document.querySelectorAll('.addons-display').forEach(display => {
        display.addEventListener('click', function(e) {
            const item = e.target.closest('.addon-item');
            if (item && !e.target.closest('.addon-item-actions')) {
                document.querySelectorAll('.addon-item').forEach(i => i.style.outline = '');
                item.style.outline = '2px solid #007bff';
                currentEditingItem = item;
            }
        });
    });

    // Close modals on outside click
    document.getElementById('editAddonModal').addEventListener('click', function(e) {
        if (e.target === this) cancelEditAddon();
    });

    document.getElementById('editServiceModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
});