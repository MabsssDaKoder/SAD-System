@extends('admin.admin-layout')

@section('title', 'Update Template')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/update-template.css') }}">
@endsection

@section('content')

<div class="page-title">UpdateTemplate</div>

<div class="">

    {{-- SMS Update --}}
    <div class="template-section">
        <h3 class="section-label">SmS Update</h3>

        <div class="template-row">
            {{-- Message Preview Left --}}
            <div class="message-bubble left">
                <p id="sms-preview-text">
                    "Good day, Ma'am/Sir. Your laundry is now ready to be picked up at the
                    shop. All items have been carefully washed and dried. Thank you very much."
                </p>
                <div class="bubble-actions">
                    <button class="btn-edit" onclick="enableEdit('sms')">Edit</button>
                    <button class="btn-confirm" id="sms-confirm" onclick="confirmEdit('sms')" disabled>Confirm</button>
                    <button class="btn-cancel" id="sms-cancel" onclick="cancelEdit('sms')" disabled>Cancel</button>
                </div>
            </div>

            {{-- Phone Preview Right --}}
            <div class="phone-preview">
                <div class="phone-bubble">
                    <p id="sms-phone-text">
                        "Good day, Ma'am/Sir. Your laundry is now ready to be picked up at the
                        shop. All items have been carefully washed and dried. Thank you very much."
                    </p>
                </div>
            </div>
        </div>

        {{-- Editable textarea (hidden by default) --}}
        <textarea id="sms-textarea" class="edit-textarea hidden" rows="4"
            placeholder="Type your SMS message here...">Good day, Ma'am/Sir. Your laundry is now ready to be picked up at the shop. All items have been carefully washed and dried. Thank you very much.</textarea>
    </div>

    <hr class="divider">

    {{-- Service Receipt --}}
    <div class="template-section">
        <h3 class="section-label">Service Receipt</h3>

        <div class="template-row">
            {{-- Message Preview Left --}}
            <div class="message-bubble left">
                <p id="receipt-preview-text">
                    "Thank you for choosing our shop for your laundry needs. We truly appreciate
                    your trust in our service and look forward to serving you again."
                </p>
            </div>

            {{-- Buttons Right --}}
            <div class="receipt-actions">
                <button class="btn-edit" onclick="enableEdit('receipt')">Edit</button>
                <button class="btn-confirm" id="receipt-confirm" onclick="confirmEdit('receipt')" disabled>Confirm</button>
                <button class="btn-cancel" id="receipt-cancel" onclick="cancelEdit('receipt')" disabled>Cancel</button>
            </div>
        </div>

        {{-- Editable textarea (hidden by default) --}}
        <textarea id="receipt-textarea" class="edit-textarea hidden" rows="4"
            placeholder="Type your receipt message here...">Thank you for choosing our shop for your laundry needs. We truly appreciate your trust in our service and look forward to serving you again.</textarea>
    </div>

    <hr class="divider">

    {{-- Receipt Preview --}}
    <div class="receipt-preview-card">
        <div class="receipt-preview-top">
            <div class="receipt-preview-left">
                <h4>WashDepot Online Receipt</h4>
                <p id="receipt-body-text">
                    Thank you for choosing our shop for your laundry needs.
                    We truly appreciate your trust in our service and look forward to serving you again.
                </p>

                <div class="receipt-field"><span>Name:</span></div>
                <div class="receipt-field"><span>Contact Number:</span></div>
                <div class="receipt-field"><span>Laundry Kg:</span></div>
                <div class="receipt-field"><span>Addons:</span></div>
                <div class="receipt-field"><span>Price:</span></div>
            </div>

            <div class="receipt-preview-right">
                <div class="qr-box">
                    <span>QR</span>
                    <small>02934</small>
                </div>
                <div class="queue-num">01</div>
                <div class="queue-label">Queue #</div>
            </div>
        </div>

        <div class="receipt-preview-bottom">
            <a href="#" class="view-queue-link">View Queueing Status</a>
            <button class="btn-confirm-receipt">Confirm</button>
        </div>
    </div>

</div>

<script src="{{ asset('js/admin/update-template.js') }}"></script>
@endsection