@extends('admin.admin-layout')

@section('title', 'Branch Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/branch.css') }}">
@endsection

@section('content')

@php
$branches = $branches ?? [
    (object)[
        'id' => 1,
        'name' => 'Main Branch',
        'address' => 'Makati City',
        'contact_number' => '09123456789',
        'contact_number_2' => '',
        'leader' => (object)['name' => 'John Doe']
    ],
    (object)[
        'id' => 2,
        'name' => 'North Branch',
        'address' => 'Taguig City',
        'contact_number' => '09987654321',
        'contact_number_2' => '',
        'leader' => (object)['name' => 'Jane Smith']
    ]
];
@endphp

<div class="page-header">
    <h1>Branch Management</h1>
    <p>Admin control: view and manage all branches</p>
</div>
<div class="page-actions">
    <button class="btn-create-branch" onclick="openCreateBranchModal()">
        + Create New Branch
    </button>
</div>
<div class="branch-grid">

    @forelse($branches as $branch)
    <div class="branch-card">

        <div class="branch-card-header">
            <span class="branch-icon"></span>
            <span class="branch-name">{{ $branch->name }}</span>
        </div>

        <div class="branch-card-body">

            <div class="branch-info-row">
                <span class="info-label">Address</span>
                <span class="info-value">{{ $branch->address }}</span>
            </div>

            <div class="branch-info-row">
                <span class="info-label">Contact</span>
                <span class="info-value">
                    {{ $branch->contact_number }}
                    @if($branch->contact_number_2)
                        / {{ $branch->contact_number_2 }}
                    @endif
                </span>
            </div>

            <div class="branch-info-row">
                <span class="info-label">Branch Leader</span>
                <span class="info-value">
                    {{ $branch->leader->name ?? '—' }}
                </span>
            </div>

        </div>

        <div class="branch-card-actions">
            <button class="btn-view-branch"
                onclick="openBranchInfo(
                    {{ $branch->id }},
                    '{{ addslashes($branch->name) }}',
                    '{{ addslashes($branch->address) }}',
                    '{{ $branch->contact_number }}',
                    '{{ $branch->contact_number_2 ?? '' }}',
                    '{{ addslashes($branch->leader->name ?? '—') }}'
                )">
                View Info
            </button>
        </div>

    </div>
    @empty
        <p style="color:#777;">No branches available.</p>
    @endforelse

</div>

{{-- MODAL 1 --}}
<div class="modal-overlay hidden" id="branchInfoModal">
    <div class="modal-box">
        <div class="modal-header">
            <h2>Branch Information</h2>
        </div>

        <div class="modal-body">
            <div class="info-block">
                <div class="info-block-label">Branch</div>
                <div class="info-block-value" id="info-branch">—</div>
            </div>

            <div class="info-block">
                <div class="info-block-label">Address</div>
                <div class="info-block-value" id="info-address">—</div>
            </div>

            <div class="info-block">
                <div class="info-block-label">Contact</div>
                <div class="info-block-value" id="info-contact">—</div>
            </div>

            <div class="info-block">
                <div class="info-block-label">Leader</div>
                <div class="info-block-value" id="info-leader">—</div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-modal-close" onclick="closeBranchInfo()">Close</button>
        </div>
    </div>
</div>
<div class="modal-overlay hidden" id="createBranchModal">
    <div class="modal-box modal-box--wide">

        <div class="modal-header">
            <h2>Create New Branch</h2>
        </div>

        <form onsubmit="submitCreateBranch(event)">
            <div class="modal-body">

                <div class="form-group">
                    <label class="form-label">Branch Name</label>
                    <input type="text" class="form-input" id="new-name" placeholder="Text...">
                </div>

                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-input" id="new-address" placeholder="Text...">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Select Staff Leader</label>
                        <input type="text" class="form-input" id="new-contact1" placeholder="Staff...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-input" id="new-contact2" placeholder="Number...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Opening Time</label>
                    <input type="time" class="form-input" id="new-open">
                </div>

                <div class="form-group">
                    <label class="form-label">Closing Time</label>
                    <input type="time" class="form-input" id="new-close">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-close" onclick="closeCreateBranchModal()">
                    Cancel
                </button>
                <button type="submit" class="btn-modal-confirm">
                    Create Branch
                </button>
            </div>

        </form>
    </div>
</div>
<script src="{{ asset('js/admin/branch.js') }}"></script>

@endsection