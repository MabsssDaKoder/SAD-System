@extends('admin.admin-layout')

@section('title', 'Logout')

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
        align-items: center;
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
        width: 100%;
        max-width: 560px;
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
        padding: 2.25rem 1.75rem;
    }

    /* ════════════════════════════════════════════════
       LOGOUT CONFIRM CARD
       ════════════════════════════════════════════════ */
    .logout-icon-wrap {
        width: 72px;
        height: 72px;
        background: #fef2f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1.5rem auto;
        border: 2px solid #fecaca;
    }

    .logout-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1a2535;
        text-align: center;
        margin: 0 0 0.6rem 0;
    }

    .logout-message {
        font-size: 0.92rem;
        color: #7a8999;
        text-align: center;
        margin: 0 0 0.5rem 0;
        line-height: 1.55;
    }

    .logout-user {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 1rem 1.25rem;
        margin: 1.5rem 0 2rem 0;
    }

    .logout-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a2535 0%, #2d4a6e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .logout-user-info h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a2535;
        margin: 0 0 0.15rem 0;
    }

    .logout-user-info p {
        font-size: 0.82rem;
        color: #7a8999;
        margin: 0;
    }

    .session-meta {
        margin-left: auto;
        text-align: right;
    }

    .session-meta .session-label {
        font-size: 0.75rem;
        color: #9aabb8;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    .session-meta .session-value {
        font-size: 0.82rem;
        color: #4a5568;
        font-weight: 600;
    }

    .logout-actions {
        display: flex;
        gap: 1rem;
    }

    .btn {
        flex: 1;
        padding: 0.8rem 1.5rem;
        border-radius: 7px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        text-align: center;
    }

    .btn-outline {
        background: white;
        color: #1a2535;
        border: 1px solid #d0d9e3;
    }

    .btn-outline:hover { background: #f0f2f5; }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-danger:hover {
        background: #b91c1c;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* ════════════════════════════════════════════════
       SESSION ACTIVITY CARD
       ════════════════════════════════════════════════ */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.9rem 0;
        border-bottom: 1px solid #f0f2f5;
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #1a2535;
        margin-top: 0.35rem;
        flex-shrink: 0;
    }

    .activity-dot.green { background: #22c55e; }
    .activity-dot.amber { background: #f59e0b; }
    .activity-dot.red   { background: #ef4444; }

    .activity-text {
        flex: 1;
    }

    .activity-text h5 {
        font-size: 0.88rem;
        font-weight: 600;
        color: #1a2535;
        margin: 0 0 0.15rem 0;
    }

    .activity-text p {
        font-size: 0.8rem;
        color: #7a8999;
        margin: 0;
    }

    .activity-time {
        font-size: 0.78rem;
        color: #9aabb8;
        white-space: nowrap;
        margin-top: 0.1rem;
    }

    /* ════════════════════════════════════════════════
       TIPS CARD
       ════════════════════════════════════════════════ */
    .tips-list {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .tip-item {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
        font-size: 0.88rem;
        color: #4a5568;
        line-height: 1.5;
    }

    .tip-icon {
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 0.05rem;
    }

    /* ════════════════════════════════════════════════
       RESPONSIVE
       ════════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .content-wrapper { padding: 1rem; }
        .logout-actions { flex-direction: column; }
        .logout-user { flex-wrap: wrap; }
        .session-meta { margin-left: 0; text-align: left; margin-top: 0.5rem; }
    }
</style>
@endsection

@section('content')

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Logout</h1>
        <p class="page-subtitle">Review your session before signing out</p>
    </div>

    <div class="content-wrapper">

        {{-- ── LOGOUT CONFIRMATION ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon">🚪</div>
                <h2 class="card-header-title">Sign Out</h2>
            </div>
            <div class="card-body">

                <div class="logout-icon-wrap">🔐</div>
                <h3 class="logout-title">Ready to leave?</h3>
                <p class="logout-message">
                    You are about to sign out of your WashDepot admin session.<br>
                    Make sure you have saved all your changes before continuing.
                </p>

                {{-- Current User --}}
                <div class="logout-user">
                    <div class="logout-avatar">AN</div>
                    <div class="logout-user-info">
                        <h4>Admin's Name</h4>
                        <p>Admin / Owner</p>
                    </div>
                    <div class="session-meta">
                        <span class="session-label">Session started</span>
                        <span class="session-value">{{ now()->format('g:i A') }}</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="logout-actions">
                    <button class="btn btn-outline" onclick="history.back()">Stay Logged In</button>
                    <form method="POST" action="{{ route('admin.logout') }}" style="flex:1; display:contents;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Yes, Sign Out</button>
                    </form>
                </div>

            </div>
        </div>

        {{-- ── RECENT SESSION ACTIVITY ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon">📋</div>
                <h2 class="card-header-title">Recent Session Activity</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-dot green"></div>
                        <div class="activity-text">
                            <h5>Logged In</h5>
                            <p>Successful login from this device</p>
                        </div>
                        <span class="activity-time">Today, {{ now()->format('g:i A') }}</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div class="activity-text">
                            <h5>Viewed Queue Status</h5>
                            <p>Opened Queue Management Board</p>
                        </div>
                        <span class="activity-time">Today, {{ now()->subMinutes(5)->format('g:i A') }}</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot amber"></div>
                        <div class="activity-text">
                            <h5>Shop Management Edited</h5>
                            <p>Updated add-on pricing for Powdered Detergent</p>
                        </div>
                        <span class="activity-time">Today, {{ now()->subMinutes(18)->format('g:i A') }}</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div class="activity-text">
                            <h5>New Laundry Order Created</h5>
                            <p>Order #1042 added to the queue</p>
                        </div>
                        <span class="activity-time">Today, {{ now()->subMinutes(34)->format('g:i A') }}</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-dot red"></div>
                        <div class="activity-text">
                            <h5>Previous Logout</h5>
                            <p>Session ended normally</p>
                        </div>
                        <span class="activity-time">Yesterday, 6:47 PM</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SECURITY TIPS ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon">🛡️</div>
                <h2 class="card-header-title">Security Reminders</h2>
            </div>
            <div class="card-body">
                <div class="tips-list">
                    <div class="tip-item">
                        <span class="tip-icon">✅</span>
                        Always log out when using a shared or public device to protect your account.
                    </div>
                    <div class="tip-item">
                        <span class="tip-icon">✅</span>
                        Close your browser tabs after signing out for added security.
                    </div>
                    <div class="tip-item">
                        <span class="tip-icon">✅</span>
                        If you notice any suspicious activity, change your password immediately from Profile Settings.
                    </div>
                    <div class="tip-item">
                        <span class="tip-icon">✅</span>
                        Never share your login credentials with others, even within your team.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection