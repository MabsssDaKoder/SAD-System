<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaundryController;



// ── Login ────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('login');
});

// ── Admin ────────────────────────────────────────────────────────────────────
Route::get('/admin/shop-management', function () {
    return view('admin.shop-management');
});
Route::get('/admin/branch-management', function () {
    return view('admin.branch-management');
});
Route::get('/admin/update-template', function () {
    return view('admin.update-template');
});
Route::get('/admin/inventory', function () {
    return view('admin.inventory-management');
});
Route::get('/admin/reports', function () {
    return view('admin.reports');
});
Route::get('/admin/account-management', function () {
    return view('admin.account-management');
});
Route::get('/admin/new-laundry', function () {
    return view('admin.new-laundry');
});

Route::get('/admin/queue', function () {
    return view('admin.queue');
});
Route::get('/admin/notifications', function () {
    return view('admin.notification');
});
// admin bottom navs
Route::get('/admin/admin-profile', function () {
    return view('admin.admin-profile');
});

Route::get('/admin/help', function () {
    return view('admin.help-and-support');
});

Route::get('/login', function () {
    return view('login');
});



// ── Public Queue ─────────────────────────────────────────────────────────────
Route::get('/queue-status',      [LaundryController::class, 'publicQueue'])->name('public.queue');
Route::get('/queue/json', [LaundryController::class, 'publicOrdersJson'])->name('public.queue.json');

// ── Staff ────────────────────────────────────────────────────────────────────
Route::get('/staff/inventory', function () {
    return view('staff.staff-inventory-management');
});
Route::get('/staff/profile', function () {
    return view('staff.staff-profile');
});
Route::get('/staff/help', function () {
    return view('staff.help-and-support');
});

Route::get('/staff/notifications', function () {
    return view('staff.notification');
});
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/new-laundry',              [LaundryController::class, 'create'])->name('new-laundry');
    Route::post('/laundry',                 [LaundryController::class, 'store'])->name('laundry.store');
    Route::get('/queue',                    [LaundryController::class, 'staffQueue'])->name('queue');
    Route::get('/queue/json',               [LaundryController::class, 'ordersJson'])->name('queue.json');
    Route::patch('/laundry/{order}/status', [LaundryController::class, 'updateStatus'])->name('laundry.status');
});