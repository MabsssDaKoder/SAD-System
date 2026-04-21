@extends('staff.staff-layout')

@section('title', 'New Laundry Service')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/staff/new-laundry.css') }}">
@endsection

@section('content')

<div class="page-header">
    <h1>Add Customer to Queue</h1>
    <p>Enter customer details and service preferences</p>
</div>

<div class="sections-wrapper">

    {{-- Customer Information --}}
    <div class="section-card">
        <h3>Customer Information</h3>
        <div class="two-col">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" id="full_name" placeholder="Enter full name">
            </div>
            <div class="input-group">
                <label>Contact Number</label>
                <input type="text" id="contact" placeholder="09XXXXXXXXX">
            </div>
        </div>
    </div>

    {{-- Service Details --}}
    <div class="section-card">
        <h3>Service Details</h3>

        <div class="input-group" style="max-width:300px;">
            <label>Laundry Weight (kg)</label>
            <input type="number" id="kg" min="0"
                step="0.1" placeholder="0.0">
        </div>

        <div class="input-group" style="margin-top:16px;">
            <label>Service Type</label>
            <div class="service-type-grid">
                <button class="service-btn active" id="btn-ordinary"
                    onclick="setService('ordinary')">
                    <span class="service-title">Ordinary</span>
                    <span class="service-sub">Standard processing time</span>
                </button>
                <button class="service-btn" id="btn-rush"
                    onclick="setService('rush')">
                    <span class="service-title">Rush</span>
                    <span class="service-sub">Priority processing</span>
                </button>
            </div>
        </div>

        <div class="input-group" id="pickup-time-group"
            style="margin-top:16px; display:none;">
            <label>Pickup Time</label>
            <input type="time" id="receiving_time" class="time-input">
        </div>

    </div>

    {{-- Custom Add-Ons --}}
    <div class="section-card">
        <h3>Customs & Add-ons</h3>
        <div class="addons-grid" id="addons-grid">

            {{-- Sample addons - admin will add real ones from DB later --}}
            <div class="addon-item"
                data-name="Tide"
                data-price="25"
                data-type="Detergent"
                onclick="toggleAddon(this)">
                <span class="addon-name">Tide</span>
                <span class="addon-type">Detergent</span>
                <span class="addon-price">₱25</span>
            </div>

            <div class="addon-item"
                data-name="Ariel"
                data-price="28"
                data-type="Detergent"
                onclick="toggleAddon(this)">
                <span class="addon-name">Ariel</span>
                <span class="addon-type">Detergent</span>
                <span class="addon-price">₱28</span>
            </div>

            <div class="addon-item"
                data-name="Downy"
                data-price="20"
                data-type="Fabric Conditioner"
                onclick="toggleAddon(this)">
                <span class="addon-name">Downy</span>
                <span class="addon-type">Fabric Conditioner</span>
                <span class="addon-price">₱20</span>
            </div>

            <div class="addon-item"
                data-name="Fabcon"
                data-price="18"
                data-type="Fabric Conditioner"
                onclick="toggleAddon(this)">
                <span class="addon-name">Fabcon</span>
                <span class="addon-type">Fabric Conditioner</span>
                <span class="addon-price">₱18</span>
            </div>

        </div>
    </div>

    {{-- Order Summary --}}
    <div class="section-card summary-card">
        <h3>Order Summary</h3>
        <div class="summary-row">
            <span id="base-label">Base Price (0 kg × ₱50)</span>
            <span id="base-price-display">₱0.00</span>
        </div>
        <div class="summary-row" id="rush-row" style="display:none;">
            <span>Rush Fee</span>
            <span id="rush-fee-display">₱50.00</span>
        </div>
        <div class="summary-row" id="addon-row" style="display:none;">
            <span>Add-ons</span>
            <span id="addon-price-display">₱0.00</span>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-total">
            <span>Total</span>
            <span id="total-display">₱0.00</span>
        </div>
    </div>

</div>

{{-- Bottom Buttons --}}
<div class="bottom-btns">
    <button class="btn-cancel-form" onclick="resetForm()">Cancel</button>
    <button class="btn-generate" onclick="generateReceipt()">Generate Receipt</button>
</div>

{{-- Receipt Modal --}}
<div class="modal-overlay hidden" id="receiptModal">
    <div class="receipt-card">

        <div class="receipt-left">
            <h3>WashDepot Online Receipt</h3>
            <p class="receipt-msg">
                Thank you for choosing our shop for your laundry needs.
                We truly appreciate your trust in our service and
                look forward to serving you again.
            </p>
            <div class="receipt-divider"></div>
            <div class="receipt-info">
                <p>Name: <strong id="r-name">-</strong></p>
                <p>Contact Number: <strong id="r-contact">-</strong></p>
                <p>Laundry Kg: <strong id="r-kg">-</strong></p>
                <p>Addons: <strong id="r-addons">-</strong></p>
                <p>Price: <strong id="r-price">-</strong></p>
            </div>
        </div>

        <div class="receipt-right">
            <div class="receipt-qr-box">
                <img id="receipt-qr-img" src="" alt="QR" width="90" height="90">
            </div>
            <div class="receipt-qr-code" id="r-qr-code">-</div>
            <div class="receipt-queue-num" id="r-queue-num">01</div>
            <div class="receipt-queue-label">Queue #</div>
        </div>

        <div class="receipt-footer">
            <a href="/queue-status" class="view-queue-link">
                View Queueing Status
            </a>
            <button class="btn-confirm-receipt" onclick="closeReceipt()">
                Confirm
            </button>
        </div>

    </div>
</div>

<script src="{{ asset('js/staff/new-laundry.js') }}"></script>
@endsection