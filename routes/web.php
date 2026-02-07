<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

// Public Auth Routes
// Route::get('/', [TicketController::class, 'index'])->name('home'); // Moved to auth
// Route::get('/scan', ...); // Moved to auth

// Auth Routes
// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', function() {
        if (auth()->user()->role === 'volunteer') {
            return redirect()->route('scan');
        }
        return redirect()->route('admin.dashboard');
    })->name('home');

    // Scan & Validator Routes (Accessible by Admin, Staff, Volunteer)
    Route::middleware(['role:admin,staff,volunteer'])->group(function () {
        Route::get('/scan', [TicketController::class, 'scan'])->name('scan');
        Route::post('/validate', [TicketController::class, 'validateTicket'])->name('validate');
        Route::get('/result/{status}', [TicketController::class, 'result'])->name('result');
        Route::get('/tickets/validated', [TicketController::class, 'validated'])->name('tickets.validated');
    });

    // Admin & Staff Area
    Route::middleware(['role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Ticket Management
        // Admin & Staff can create/edit.
        // Volunteers are excluded here.
        Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class);
        Route::get('tickets/{ticket}/export', [\App\Http\Controllers\Admin\TicketController::class, 'export'])->name('tickets.export');
        Route::get('tickets/{ticket}/preview', [\App\Http\Controllers\Admin\TicketController::class, 'preview'])->name('tickets.preview');
    });

    // Admin Only Area
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    });

});

