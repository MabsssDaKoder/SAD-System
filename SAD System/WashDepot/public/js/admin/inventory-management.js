let items = [];

function enableForm(mode) {
    document.getElementById('item_name').disabled      = false;
    document.getElementById('reorder_point').disabled  = false;
    document.getElementById('current_stocks').disabled = false;
    document.getElementById('cat_det').disabled        = false;
    document.getElementById('cat_conditioner').disabled = false;
    document.getElementById('saveBtn').disabled   = false;
    document.getElementById('cancelBtn').disabled = false;

    if (mode === 'add') {
        document.getElementById('item_name').value      = '';
        document.getElementById('reorder_point').value  = '';
        document.getElementById('current_stocks').value = '';
    }
}

function disableForm() {
    document.getElementById('item_name').disabled      = true;
    document.getElementById('reorder_point').disabled  = true;
    document.getElementById('current_stocks').disabled = true;
    document.getElementById('cat_det').disabled        = true;
    document.getElementById('cat_conditioner').disabled = true;
    document.getElementById('saveBtn').disabled   = true;
    document.getElementById('cancelBtn').disabled = true;

    document.getElementById('item_name').value      = '';
    document.getElementById('reorder_point').value  = '';
    document.getElementById('current_stocks').value = '';
}

function getStatus(reorder, stocks) {
    if (stocks <= 0)           return '<span class="status outofstock">Out of Stocks</span>';
    if (stocks <= reorder / 2) return '<span class="status reorder">Re-Order</span>';
    return '<span class="status good">Good</span>';
}

function renderTable() {
    const tbody = document.getElementById('inventory-body');
    tbody.innerHTML = '';

    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="empty-msg">No items found.</td></tr>';
        return;
    }

    items.forEach((item, index) => {
        const status  = getStatus(item.reorder, item.stocks);
        const alertIcon = item.stocks <= 0 ? '<span class="alert-icon">!</span>' : '';
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${alertIcon} ${item.name}</td>
            <td>${item.category}</td>
            <td>${item.reorder}</td>
            <td>${item.stocks}</td>
            <td>${status}</td>
            <td><button class="btn-notify">Notify</button></td>
        `;
        tbody.appendChild(row);
    });
}

// function saveItem() {
//     const name     = document.getElementById('item_name').value.trim();
//     const reorder  = parseInt(document.getElementById('reorder_point').value);
//     const stocks   = parseInt(document.getElementById('current_stocks').value);
//     const category = document.getElementById('cat_det').classList.contains('active')
//         ? 'Powdered Soap' : 'Fabric Conditioner';

//     if (!name || isNaN(reorder) || isNaN(stocks)) {
//         alert('Please fill in all fields!');
//         return;
//     }

//     items.push({ name, category, reorder, stocks });
//     renderTable();
//     disableForm();
// }
function saveItem() {
    const name     = document.getElementById('item_name').value.trim();
    const reorder  = parseInt(document.getElementById('reorder_point').value);
    const stocks   = parseInt(document.getElementById('current_stocks').value);
    const category = document.getElementById('cat_det').classList.contains('active')
        ? 'Powdered Soap' : 'Fabric Conditioner';

    if (!name || isNaN(reorder) || isNaN(stocks)) {
        alert('Please fill in all fields!');
        return;
    }

    // Check if item already exists
    const existingIndex = items.findIndex(
        item => item.name.toLowerCase() === name.toLowerCase()
    );

    if (existingIndex !== -1) {
        // Ask if they want to edit
        const confirm = window.confirm(
            `"${name}" already exists in the table. Do you want to update it instead?`
        );

        if (confirm) {
            // Update existing item
            items[existingIndex] = { name, category, reorder, stocks };
            renderTable();
            disableForm();
        }
        // If No, just stay on form so they can change the name
        return;
    }

    // Add new item
    items.push({ name, category, reorder, stocks });
    renderTable();
    disableForm();
}

// Category toggle
document.getElementById('cat_det').addEventListener('click', function() {
    document.getElementById('cat_det').classList.add('active');
    document.getElementById('cat_conditioner').classList.remove('active');
});

document.getElementById('cat_conditioner').addEventListener('click', function() {
    document.getElementById('cat_conditioner').classList.add('active');
    document.getElementById('cat_det').classList.remove('active');
});

// Initial render
renderTable();