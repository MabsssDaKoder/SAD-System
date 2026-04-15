// Store original text
const originalText = {
    sms:     document.getElementById('sms-preview-text').textContent.trim(),
    receipt: document.getElementById('receipt-preview-text').textContent.trim()
};

// Enable edit
function enableEdit(type) {
    const textarea  = document.getElementById(`${type}-textarea`);
    const preview   = document.getElementById(`${type}-preview-text`);
    const confirmBtn = document.getElementById(`${type}-confirm`);
    const cancelBtn  = document.getElementById(`${type}-cancel`);

    // Show textarea with current text
    textarea.value = preview.textContent.trim().replace(/"/g, '');
    textarea.classList.remove('hidden');

    // Enable buttons
    confirmBtn.disabled = false;
    cancelBtn.disabled  = false;
}

// Confirm edit
function confirmEdit(type) {
    const textarea  = document.getElementById(`${type}-textarea`);
    const preview   = document.getElementById(`${type}-preview-text`);
    const confirmBtn = document.getElementById(`${type}-confirm`);
    const cancelBtn  = document.getElementById(`${type}-cancel`);

    const newText = textarea.value.trim();

    if (!newText) {
        alert('Message cannot be empty!');
        return;
    }

    // Update preview
    preview.textContent = `"${newText}"`;

    // Update phone preview for SMS
    if (type === 'sms') {
        document.getElementById('sms-phone-text').textContent = `"${newText}"`;
    }

    // Update receipt preview
    if (type === 'receipt') {
        document.getElementById('receipt-body-text').textContent = newText;
    }

    // Hide textarea
    textarea.classList.add('hidden');
    confirmBtn.disabled = true;
    cancelBtn.disabled  = true;
}

// Cancel edit
function cancelEdit(type) {
    const textarea   = document.getElementById(`${type}-textarea`);
    const confirmBtn = document.getElementById(`${type}-confirm`);
    const cancelBtn  = document.getElementById(`${type}-cancel`);

    textarea.classList.add('hidden');
    confirmBtn.disabled = true;
    cancelBtn.disabled  = true;
}