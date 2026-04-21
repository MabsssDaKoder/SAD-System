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

{{-- Item Information Form --}}
<div class="item-form-section">

    <div class="form-action-btns">
        <button class="action-btn" onclick="enableForm('add')">Add</button>
        <button class="action-btn" onclick="enableForm('edit')">Edit</button>
        <button class="action-btn" id="saveBtn" onclick="saveItem()" disabled>Save</button>
        <button class="action-btn" id="cancelBtn" onclick="disableForm()" disabled>Cancel</button>
    </div>

    <div class="item-form">
        <h3 class="form-title">Item Information</h3>

        <div class="field-row">
            <label>Item Name:</label>
            <input type="text" id="item_name" class="form-input" disabled>
        </div>

        <div class="field-row">
            <label>Item Category</label>
            <div class="category-btns">
                <button class="cat-btn active" id="cat_det" disabled>Powdered Detergent</button>
                <button class="cat-btn" id="cat_conditioner" disabled>Fabric Conditioner</button>
            </div>
        </div>

        <div class="field-row">
            <label>Re-Order Point :</label>
            <input type="number" id="reorder_point" class="form-input" min="0" disabled>
        </div>

        <div class="field-row">
            <label>Current Stocks :</label>
            <input type="number" id="current_stocks" class="form-input" min="0" disabled>
        </div>

    </div>

</div>

<script src="{{ asset('js/admin/inventory-management.js') }}"></script>
@endsection