@extends('admin.admin-layout')

@section('title', 'Shop Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/shop-management.css') }}">
@endsection

@section('content')

<div class="page-title">Shop Management</div>

<div class="shop-card">

    {{-- Price Adjustment --}}
    <h3 class="section-title">Price Adjustment</h3>

    <div class="field-row">
        <label>Base Price :</label>
        <input type="number" min="0" id="base_price">
    </div>
    <div class="field-row">
        <label>Base Kg :</label>
        <input type="number" min="0" id="base_kg">
    </div>
    <div class="field-row">
        <label>Additional Per Kg :</label>
        <input type="number" min="0" id="additional_per_kg">
    </div>

    {{-- Custom Add-Ons --}}
    <div class="addons-section">
        <h3 class="section-title">Custom / Add-Ons</h3>

        <div class="addons-form">
            <div class="addons-form-left">

                <div class="field-row">
                    <label>Item Name</label>
                    <input type="text" id="addon_name" class="addon-input" disabled>
                </div>

                <div class="field-row">
                    <label>Item Category</label>
                    <div class="category-btns">
                        <button class="cat-btn active" id="cat_soap" disabled>Powdered Detergent</button>
                        <button class="cat-btn" id="cat_conditioner" disabled>Fabric Conditioner</button>
                    </div>
                </div>

                <div class="field-row">
                    <label>Price per Pack :</label>
                    <input type="number" min="0" id="addon_price" class="addon-input" disabled>
                </div>

            </div>

            <div class="addons-form-right">
                <button class="action-btn add" onclick="enableForm('add')">Add</button>
                <button class="action-btn edit" onclick="enableForm('edit')">Edit</button>
                <button class="action-btn save" id="saveAddonBtn" onclick="saveAddon()" disabled>Save</button>
                <button class="action-btn cancel" id="cancelAddonBtn" onclick="disableForm()" disabled>Cancel</button>
            </div>
        </div>

        {{-- Addon Cards --}}
        <div class="addon-cards">
            <div class="addon-card">
                <div class="addon-card-header">Powdered Detergent</div>
                <div class="addon-card-body" id="det-list">
                    {{-- Items --}}
                </div>
            </div>

            <div class="addon-card">
                <div class="addon-card-header">Fabric Conditioner</div>
                <div class="addon-card-body" id="conditioner-list">
                    {{-- Items --}}
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom Buttons --}}
    <div class="btn-row">
        <button class="btn-save">Save Changes</button>
        <button class="btn-cancel">Cancel</button>
    </div>

</div>

<script src="{{ asset('js/admin/shop-management.js') }}"></script>
@endsection