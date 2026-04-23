@extends('staff.staff-layout')

@section('title', 'Profile Settings')

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
    .card-body { padding: 1.75rem; }

    .avatar-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding-bottom: 1.75rem;
        margin-bottom: 1.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .avatar-wrapper { position: relative; flex-shrink: 0; }
    .avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a2535 0%, #2d4a6e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 700;
        color: white;
        letter-spacing: -1px;
        border: 3px solid #e2e8f0;
    }
    .avatar-badge {
        position: absolute;
        bottom: 4px; right: 4px;
        width: 20px; height: 20px;
        background: #22c55e;
        border-radius: 50%;
        border: 2px solid white;
    }
    .avatar-info h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a2535;
        margin: 0 0 0.25rem 0;
    }
    .avatar-info .role-badge {
        display: inline-block;
        padding: 0.2rem 0.75rem;
        background: #e8f0fe;
        color: #1a2535;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .avatar-info p { font-size: 0.85rem; color: #7a8999; margin: 0; }
    .avatar-upload-btn {
        margin-left: auto;
        padding: 0.55rem 1.25rem;
        background: white;
        border: 1px solid #d0d9e3;
        border-radius: 7px;
        font-size: 0.88rem;
        font-weight: 600;
        color: #1a2535;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .avatar-upload-btn:hover { background: #f0f2f5; border-color: #1a2535; }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem 2rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .form-group.span-2 { grid-column: span 2; }
    .form-group label { font-size: 0.85rem; font-weight: 600; color: #4a5568; }
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
    .form-group input:disabled { background: #f5f7fa; color: #7a8999; cursor: not-allowed; }
    .input-hint { font-size: 0.78rem; color: #9aabb8; }

    .section-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0.5rem 0 1.25rem 0;
    }
    .section-divider span {
        font-size: 0.82rem;
        font-weight: 700;
        color: #9aabb8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }
    .section-divider::before,
    .section-divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }

    .password-strength { display: flex; gap: 4px; margin-top: 0.35rem; }
    .strength-bar {
        flex: 1; height: 4px; border-radius: 2px;
        background: #e2e8f0; transition: background 0.3s;
    }
    .strength-bar.weak   { background: #ef4444; }
    .strength-bar.fair   { background: #f59e0b; }
    .strength-bar.good   { background: #22c55e; }
    .strength-bar.strong { background: #16a34a; }
    .strength-label { font-size: 0.78rem; color: #7a8999; margin-top: 0.25rem; }

    .action-row {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 0.5rem;
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
    .btn-primary { background: #1a2535; color: white; }
    .btn-primary:hover { background: #2d4a6e; box-shadow: 0 4px 12px rgba(26,37,53,0.25); }
    .btn-outline { background: white; color: #1a2535; border: 1px solid #d0d9e3; }
    .btn-outline:hover { background: #f0f2f5; }

    .toggle-list { display: flex; flex-direction: column; gap: 1.1rem; }
    .toggle-row { display: flex; align-items: center; justify-content: space-between; }
    .toggle-label h4 { font-size: 0.92rem; font-weight: 600; color: #1a2535; margin: 0 0 0.15rem 0; }
    .toggle-label p { font-size: 0.8rem; color: #7a8999; margin: 0; }
    .toggle { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0;
        background: #d0d9e3; border-radius: 24px;
        cursor: pointer; transition: 0.3s;
    }
    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 18px; height: 18px;
        left: 3px; top: 3px;
        background: white; border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .toggle input:checked + .toggle-slider { background: #1a2535; }
    .toggle input:checked + .toggle-slider::before { transform: translateX(20px); }

    @media (max-width: 768px) {
        .content-wrapper { padding: 1rem; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.span-2 { grid-column: span 1; }
        .avatar-section { flex-wrap: wrap; }
        .avatar-upload-btn { margin-left: 0; }
        .action-row { flex-direction: column-reverse; }
        .btn { width: 100%; text-align: center; }
    }
</style>
@endsection

@section('content')
<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Profile Settings</h1>
        <p class="page-subtitle">Manage your account details and preferences</p>
    </div>

    <div class="content-wrapper">

        {{-- ── PERSONAL INFORMATION ── --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-header-title">Personal Information</h2>
            </div>
            <div class="card-body">

                <div class="avatar-section">
                    <div class="avatar-wrapper">
                        <div class="avatar">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'S', 0, 2)) }}
                        </div>
                        <div class="avatar-badge"></div>
                    </div>
                    <div class="avatar-info">
                        <h3>{{ auth()->user()?->name ?? "Staff's Name" }}</h3>
                        <span class="role-badge">Staff · {{ auth()->user()?->branch ?? 'Branch A' }}</span>
                        <p>Last login: Today at {{ now()->format('g:i A') }}</p>
                    </div>
                    <button class="avatar-upload-btn" onclick="document.getElementById('avatar_input').click()">
                        📷 Change Photo
                    </button>
                    <input type="file" id="avatar_input" accept="image/*" style="display:none">
                </div>

                <div class="section-divider"><span>Basic Details</span></div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" placeholder="First name" value="{{ explode(' ', auth()->user()?->name ?? 'Staff')[0] }}">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" placeholder="Last name" value="{{ explode(' ', auth()->user()?->name ?? 'Staff Name')[1] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="email@example.com" value="{{ auth()->user()?->email ?? 'staff@washdepot.com' }}">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" placeholder="+63 9XX XXX XXXX">
                    </div>
                    <div class="form-group span-2">
                        <label>Role</label>
                        <input type="text" value="Staff · {{ auth()->user()?->team ?? 'Team A' }}" disabled>
                        <span class="input-hint">Your role is assigned by the system and cannot be changed.</span>
                    </div>
                </div>

                <div class="action-row" style="margin-top:1.5rem;">
                    <button class="btn btn-outline">Discard</button>
                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>

        {{-- ── CHANGE PASSWORD ── --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-header-title">Change Password</h2>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group span-2">
                        <label>Current Password</label>
                        <input type="password" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" placeholder="Enter new password" oninput="checkStrength(this.value)">
                        <div class="password-strength">
                            <div class="strength-bar" id="bar1"></div>
                            <div class="strength-bar" id="bar2"></div>
                            <div class="strength-bar" id="bar3"></div>
                            <div class="strength-bar" id="bar4"></div>
                        </div>
                        <span class="strength-label" id="strength_label">Enter a password</span>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" placeholder="Confirm new password">
                    </div>
                </div>
                <div class="action-row" style="margin-top:1.5rem;">
                    <button class="btn btn-outline">Cancel</button>
                    <button class="btn btn-primary">Update Password</button>
                </div>
            </div>
        </div>

        {{-- ── NOTIFICATIONS ── --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-header-title">Notification Preferences</h2>
            </div>
            <div class="card-body">
                <div class="toggle-list">
                    <div class="toggle-row">
                        <div class="toggle-label">
                            <h4>New Order Alerts</h4>
                            <p>Get notified when a new laundry order is assigned to you</p>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-row">
                        <div class="toggle-label">
                            <h4>Order Status Updates</h4>
                            <p>Notify when an order moves to Processing or Complete</p>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-row">
                        <div class="toggle-label">
                            <h4>Low Inventory Alerts</h4>
                            <p>Warn when add-on stock falls below threshold</p>
                        </div>
                        <label class="toggle">
                            <input type="checkbox">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
                <div class="action-row" style="margin-top:1.5rem;">
                    <button class="btn btn-primary">Save Preferences</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function checkStrength(val) {
    const bars = [document.getElementById('bar1'), document.getElementById('bar2'),
                  document.getElementById('bar3'), document.getElementById('bar4')];
    const label = document.getElementById('strength_label');
    bars.forEach(b => { b.className = 'strength-bar'; });
    let score = 0;
    if (val.length >= 8)        score++;
    if (/[A-Z]/.test(val))      score++;
    if (/[0-9]/.test(val))      score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = ['', 'weak', 'fair', 'good', 'strong'];
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    for (let i = 0; i < score; i++) bars[i].classList.add(levels[score]);
    label.textContent = val.length ? (labels[score] || 'Enter a password') : 'Enter a password';
}
</script>
@endsection