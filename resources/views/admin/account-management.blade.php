@extends('admin.admin-layout')

@section('title', 'Accounts Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/account-management.css') }}">
@endsection

@section('content')

<div class="page-title">Accounts Management</div>

<div class="accounts-wrapper">

    {{-- Left Side --}}
    <div class="left-panel">

        {{-- Staff Table --}}
        <div class="table-card">

            <div class="toolbar">
                <input type="text" class="search-input" placeholder="Search...">
                <button class="btn-teams" onclick="openTeamsModal()">Teams</button>
                <button class="btn-create" onclick="openCreateAccount()">Create Account</button>
            </div>

            <div class="table-wrapper">
                <table class="staff-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Team</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="staff-tbody">
                        <tr>
                            <td>Joana Mae Peras</td>
                            <td>Leader</td>
                            <td>Team A</td>
                            <td><span class="status active">Active</span></td>
                            <td>
                                <button class="btn-action edit">Edit</button>
                                <button class="btn-action delete">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jinky Holans</td>
                            <td>Member</td>
                            <td>Team A</td>
                            <td><span class="status inactive">Inactive</span></td>
                            <td>
                                <button class="btn-action edit">Edit</button>
                                <button class="btn-action delete">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Team Management --}}
        <div class="team-card">
            <div class="team-header">
                <span>Team Management</span>
                <button class="btn-create-team" onclick="openCreateTeam()">Create Team</button>
            </div>

            <div class="team-list" id="team-list">
                <div class="team-item active">
                    <span class="team-name">Joana Mae Peras</span>
                    <span class="team-role">Team Leader</span>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- ==================== CREATE ACCOUNT MODAL ==================== --}}
<div class="modal-overlay hidden" id="createAccountModal">
    <div class="modal-card"> 

        <!-- <h3 class="modal-title">Create New Account</h3> -->
<h3 id="modal-account-title" class="modal-account-title">Create New Account</h3>        {{-- Personal Info --}}
        <p class="modal-section-label">Staff's Personal Information</p>

        <div class="field-row">
            <label>First Name :</label>
            <input type="text" id="acc_first_name">
        </div>
        <div class="field-row">
            <label>Last Name :</label>
            <input type="text" id="acc_last_name">
        </div>
        <div class="field-row">
            <label>Contact Number :</label>
            <input type="text" id="acc_contact">
        </div>
        <div class="field-row">
            <label>Birthday :</label>
            <input type="date" id="acc_birthday">
            <label>Age :</label>
            <input type="number" id="acc_age" min="0" style="width:60px;">
        </div>
        <div class="field-row">
            <label>Sex :</label>
            <label class="radio-label">
                <input type="radio" name="acc_sex" value="male"> Male
            </label>
            <label class="radio-label">
                <input type="radio" name="acc_sex" value="female"> Female
            </label>
        </div>

        {{-- Login Info --}}
        <div class="login-info-header">
            <p class="modal-section-label">Login Information</p>
            <button class="btn-generate" onclick="generateAccount()">Generate Account</button>
        </div>

        <div class="temp-account-box">
            <h4>Temporary Account</h4>
            <div class="field-row">
                <label>Username:</label>
                <span id="gen_username">-</span>
            </div>
            <div class="field-row">
                <label>Password :</label>
                <span id="gen_password">-</span>
            </div>
            <small class="temp-note">
                Note: This Temporary Account is used to access the account,
                the password can be changed after accessing the account.
            </small>
        </div>

        <div class="modal-btns">
            <button class="btn-confirm" onclick="confirmAccount()">Confirm</button>
            <button class="btn-cancel" onclick="closeCreateAccount()">Cancel</button>
        </div>

    </div>
</div>

{{-- ==================== CREATE TEAM MODAL ==================== --}}
<div class="modal-overlay hidden" id="createTeamModal">
    <div class="modal-card">

        <!-- <h3 class="modal-title">Create Team</h3> -->

<h3 id="modal-team-title" class="modal-title">Create Team</h3>        <div class="field-row">
            <label>Team Name:</label>
            <input type="text" id="team_name" style="flex:1;">
        </div>

        <div class="field-row">
            <button class="btn-role-label">Team Leader</button>
            <input type="text" id="team_leader" placeholder="Staff list" style="flex:1;">
        </div>

        <div class="field-row">
            <button class="btn-role-label">Add Member</button>
            <input type="text" id="team_member" placeholder="Staff list" style="flex:1;">
        </div>

        {{-- Member List --}}
        <div class="member-list-box">
            <div class="member-list-header">Member List</div>
            <div class="member-list-body" id="member-list">
                <div class="member-slot"></div>
                <div class="member-slot"></div>
                <div class="member-slot"></div>
                <div class="member-slot"></div>
            </div>
        </div>

        <div class="modal-btns">
            <button class="btn-confirm" onclick="confirmTeam()">Confirm</button>
            <button class="btn-cancel" onclick="closeCreateTeam()">Cancel</button>
        </div>

    </div>
</div>

<script src="{{ asset('js/admin/account-management.js') }}"></script>
@endsection