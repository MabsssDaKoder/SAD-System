@extends('admin.admin-layout')

@section('title', 'Help & Support')

@section('styles')
<style>
    /* ════════════════════════════════════════════════
       LAYOUT
       ════════════════════════════════════════════════ */
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
    }

    .page-title {
        font-size: 1.9rem;
        font-weight: 700;
        color: #1a2535;
        margin: 0 0 0.25rem 0;
    }

    .page-subtitle {
        font-size: 0.9rem;
        color: #7a8999;
        margin: 0;
    }

    .content-wrapper {
        flex: 1;
        padding: 1.5rem 2rem 2rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* ════════════════════════════════════════════════
       CARD
       ════════════════════════════════════════════════ */
    .card {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem 1.75rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-icon {
        width: 36px;
        height: 36px;
        background: #1a2535;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .card-header-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1a2535;
        margin: 0;
    }

    .card-body {
        padding: 1.75rem;
    }

    /* ════════════════════════════════════════════════
       QUICK CONTACT CARDS
       ════════════════════════════════════════════════ */
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }

    .contact-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .contact-card:hover {
        border-color: #1a2535;
        box-shadow: 0 4px 16px rgba(26, 37, 53, 0.1);
        transform: translateY(-2px);
    }

    .contact-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem auto;
    }

    .contact-card-icon.blue  { background: #dbeafe; }
    .contact-card-icon.green { background: #dcfce7; }
    .contact-card-icon.amber { background: #fef3c7; }

    .contact-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a2535;
        margin: 0 0 0.35rem 0;
    }

    .contact-card p {
        font-size: 0.82rem;
        color: #7a8999;
        margin: 0 0 0.75rem 0;
        line-height: 1.4;
    }

    .contact-card .contact-link {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1a2535;
    }

    /* ════════════════════════════════════════════════
       FAQ
       ════════════════════════════════════════════════ */
    .faq-search {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .faq-search input {
        flex: 1;
        padding: 0.7rem 1rem 0.7rem 2.75rem;
        border: 1px solid #d0d9e3;
        border-radius: 7px;
        font-size: 0.92rem;
        color: #1a2535;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .faq-search input:focus {
        outline: none;
        border-color: #1a2535;
        box-shadow: 0 0 0 3px rgba(26,37,53,0.08);
    }

    .faq-search-wrap {
        position: relative;
        flex: 1;
    }

    .faq-search-wrap::before {
        content: '🔍';
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.85rem;
        pointer-events: none;
    }

    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .faq-item {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }

    .faq-question {
        width: 100%;
        background: none;
        border: none;
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.92rem;
        font-weight: 600;
        color: #1a2535;
        cursor: pointer;
        text-align: left;
        transition: background 0.2s;
    }

    .faq-question:hover {
        background: #f8fafc;
    }

    .faq-question .faq-icon {
        font-size: 1rem;
        transition: transform 0.25s;
        flex-shrink: 0;
        margin-left: 1rem;
        color: #7a8999;
    }

    .faq-item.open .faq-icon {
        transform: rotate(45deg);
    }

    .faq-answer {
        display: none;
        padding: 0 1.25rem 1.1rem 1.25rem;
        font-size: 0.88rem;
        color: #4a5568;
        line-height: 1.65;
        border-top: 1px solid #e2e8f0;
    }

    .faq-item.open .faq-answer {
        display: block;
    }

    .faq-answer p { margin: 0.6rem 0 0 0; }

    /* ════════════════════════════════════════════════
       SUBMIT A TICKET
       ════════════════════════════════════════════════ */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }

    .form-group:last-of-type { margin-bottom: 0; }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #4a5568;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 0.7rem 1rem;
        border: 1px solid #d0d9e3;
        border-radius: 7px;
        font-size: 0.92rem;
        color: #1a2535;
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #1a2535;
        box-shadow: 0 0 0 3px rgba(26,37,53,0.08);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 110px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .action-row {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .btn {
        padding: 0.7rem 2rem;
        border-radius: 7px;
        font-weight: 600;
        font-size: 0.92rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #1a2535;
        color: white;
    }

    .btn-primary:hover {
        background: #2d4a6e;
        box-shadow: 0 4px 12px rgba(26,37,53,0.25);
    }

    .btn-outline {
        background: white;
        color: #1a2535;
        border: 1px solid #d0d9e3;
    }

    .btn-outline:hover { background: #f0f2f5; }

    /* ════════════════════════════════════════════════
       SYSTEM INFO
       ════════════════════════════════════════════════ */
    .sysinfo-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .sysinfo-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        padding: 0.85rem 1rem;
        background: #f8fafc;
        border-radius: 7px;
        border: 1px solid #e2e8f0;
    }

    .sysinfo-item .label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #9aabb8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .sysinfo-item .value {
        font-size: 0.92rem;
        font-weight: 600;
        color: #1a2535;
    }

    /* ════════════════════════════════════════════════
       RESPONSIVE
       ════════════════════════════════════════════════ */
    @media (max-width: 900px) {
        .contact-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
        .content-wrapper { padding: 1rem; }
        .contact-grid { grid-template-columns: 1fr; }
        .form-grid-2 { grid-template-columns: 1fr; }
        .sysinfo-grid { grid-template-columns: 1fr; }
        .action-row { flex-direction: column-reverse; }
        .btn { width: 100%; text-align: center; }
    }
</style>
@endsection

@section('content')

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Help & Support</h1>
        <p class="page-subtitle">Find answers, get in touch, or report an issue</p>
    </div>

    <div class="content-wrapper">

        {{-- ── QUICK CONTACT ── --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-header-title">Quick Contact</h2>
            </div>
            <div class="card-body">
                <div class="contact-grid">
                   
                    <div class="contact-card">
                        <div class="contact-card-icon amber">📞</div>
                        <h4>Phone Support</h4>
                        <p>Call us Mon–Fri, 8 AM – 6 PM (Philippine Standard Time)</p>
                        <span class="contact-link">+63 2 8XXX XXXX</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── FAQ ── --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-header-title">Frequently Asked Questions</h2>
            </div>
            <div class="card-body">
                <div class="faq-search">
                    <div class="faq-search-wrap">
                        <input type="text" placeholder="Search questions..." oninput="filterFaq(this.value)">
                    </div>
                </div>

                <div class="faq-list" id="faq-list">

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            How do I add a new branch to the system?
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Go to <strong>Branch Management</strong> in the sidebar, then click the <em>Add Branch</em> button. Fill in the branch name, address, and assign a manager. Save to activate the new branch.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            How do I change the pricing for a service type?
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Navigate to <strong>Shop Management → Service Types</strong>. Click the pencil (✎) icon on the service chip you want to edit. Update the name or price in the modal and click <em>Save Changes</em>.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            How do I move an order from Pending to Processing?
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Open the <strong>Queue Status</strong> board. Find the order under the <em>Pending</em> column, then use the action button on the order card to move it to <em>Processing</em>. The count will update automatically.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            Can I export sales reports?
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Yes. Go to <strong>Reports / Sales</strong> in the sidebar, select your date range and branch, then click <em>Export CSV</em> or <em>Export PDF</em>. Reports include order counts, revenue totals, and per-service breakdowns.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            How do I reset another user's password?
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Go to <strong>Account Management</strong>, find the user and click <em>Edit</em>. Use the <em>Reset Password</em> option to send them a password reset link via email.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)">
                            What do I do if the system is running slow?
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>First try refreshing your browser and clearing the cache. If the issue persists, check your internet connection. You can also submit a support ticket below with details about the slowness so our team can investigate.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── SUBMIT A TICKET ── --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-header-title">Send Support Email</h2>
            </div>
            <div class="card-body">

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" placeholder="Admin's Name" value="Admin's Name">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="admin@washdepot.com" value="admin@washdepot.com">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Issue Category</label>
                        <select>
                            <option value="">Select a category</option>
                            <option>Order / Queue Issue</option>
                            <option>Account / Login</option>
                            <option>Feature Request</option>
                            <option>Bug Report</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <select>
                            <option>Low</option>
                            <option selected>Medium</option>
                            <option>High</option>
                            <option>Urgent</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" placeholder="Brief description of your issue">
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea placeholder="Please describe your issue in detail. Include steps to reproduce if reporting a bug."></textarea>
                </div>
<div class="form-group" style="margin-bottom: 1.5rem; padding: 0.85rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; flex-direction: row; align-items: center; gap: 0.5rem;">
        <span style="font-size: 0.85rem; font-weight: 600; color: #4a5568; white-space: nowrap;">Send to:</span>
        <span style="font-size: 0.92rem; font-weight: 600; color: #1a2535;">devteam@washdepot.com</span>
    </div>

    <div class="form-grid-2">
                <div class="action-row">
                    <button class="btn btn-outline">Clear</button>
                    <button class="btn btn-primary">Submit Email</button>
                </div>

            </div>
        </div>

       
    </div>
</div>

<script>
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const wasOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!wasOpen) item.classList.add('open');
}

function filterFaq(query) {
    const q = query.toLowerCase();
    document.querySelectorAll('.faq-item').forEach(item => {
        const text = item.querySelector('.faq-question').textContent.toLowerCase();
        item.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>
@endsection