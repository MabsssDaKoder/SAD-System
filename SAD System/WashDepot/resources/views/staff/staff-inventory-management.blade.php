@extends('admin.admin-layout')

@section('title', 'Inventory Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/inventory-management.css') }}">
@endsection

@section('content')

<div class="page-title">Inventory Management</div>

<div class="inventory-card">

    {{-- Search & Categories --}}
    <div class="toolbar">
        <input type="text" class="search-input" placeholder="Search Item name...">
        <button class="btn-categories">Categories</button>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Categories</th>
                    <th>Re-Order Point</th>
                    <th>Stocks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        
                <tbody id="inventory-body">
    <tr>
        <td colspan="6" class="empty-msg">No items found.</td>
    </tr>
</tbody>
           
        </table>
    </div>

</div>



</div>

<script src="{{ asset('js/admin/inventory-management.js') }}"></script>
@endsection