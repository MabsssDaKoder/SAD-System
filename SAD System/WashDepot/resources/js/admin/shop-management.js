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

    if (category === 'Powdered Soap') {
        document.getElementById('soap-list').appendChild(item);
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