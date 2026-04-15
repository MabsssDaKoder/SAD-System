@extends('staff.staff-layout')

@section('title', 'Queue Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/staff/queue.css') }}">
@endsection

@section('content')

<div class="page-header">
    <h1>Queue Management Board</h1>
    <p>Track and manage customer laundry status</p>
</div>

<div class="queue-board">

    {{-- Pending Column --}}
    <div class="queue-column">
        <div class="col-header pending">
            Pending (<span id="pending-count">0</span>)
        </div>
        <div class="col-body" id="pending-list"></div>
    </div>

    {{-- Processing Column --}}
    <div class="queue-column">
        <div class="col-header processing">
            Processing (<span id="processing-count">0</span>)
        </div>
        <div class="col-body" id="processing-list"></div>
    </div>

    {{-- Complete Column --}}
    <div class="queue-column">
        <div class="col-header complete">
            Complete (<span id="complete-count">0</span>)
        </div>
        <div class="col-body" id="complete-list"></div>
    </div>

</div>

{{-- SMS Modal --}}
<div class="modal-overlay hidden" id="smsModal">
    <div class="sms-modal">
        <h3>📱 SMS Update</h3>
        <p>Send notification to customer:</p>
        <div class="sms-preview">
            "Good day, Ma'am/Sir. Your laundry is now ready to be
            picked up at the shop. All items have been carefully
            washed and dried. Thank you very much."
        </div>
        <p class="sms-to">Sending to: <strong id="sms-contact">-</strong></p>
        <div class="sms-btns">
            <button class="btn-send" onclick="confirmSMS()">Send</button>
            <button class="btn-cancel-sms" onclick="closeSMS()">Cancel</button>
        </div>
    </div>
</div>

{{-- SMS Sent Modal --}}
<div class="modal-overlay hidden" id="smsSentModal">
    <div class="sms-modal" style="text-align:center;">
        <div style="font-size:48px;">✅</div>
        <h3>Message Sent!</h3>
        <p>The customer has been notified via SMS.</p>
        <button class="btn-send" onclick="closeSMSSent()" style="margin-top:16px;">OK</button>
    </div>
</div>

<script src="{{ asset('js/staff/queue.js') }}"></script>
@endsection