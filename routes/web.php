<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home page (using welcome blade)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// public pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');

// Authentication routes
require __DIR__.'/auth.php';

// Profile routes 
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Member routes
Route::middleware(['auth'])->group(function () {
    Route::post('/deposit', [MemberController::class, 'deposit'])->name('deposit');
    Route::get('/transactions', [MemberController::class, 'transactions'])->name('transactions');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    // Member Management Routes
    Route::get('/admin/members', [AdminController::class, 'members'])->name('admin.members');
    Route::get('/admin/members/register', [AdminController::class, 'showRegistrationForm'])->name('admin.members.register');
    Route::post('/admin/members/store', [AdminController::class, 'storeMember'])->name('admin.members.store');
    Route::get('/admin/members/{id}/edit', [AdminController::class, 'editMember'])->name('admin.members.edit');
    Route::put('/admin/members/{id}', [AdminController::class, 'updateMember'])->name('admin.members.update');
    Route::delete('/admin/members/{id}', [AdminController::class, 'destroyMember'])->name('admin.members.destroy');
    
    // Transactions & Reports
    Route::get('/admin/transactions', [AdminController::class, 'allTransactions'])->name('admin.transactions');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
});