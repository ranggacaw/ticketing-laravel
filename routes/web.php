<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

// Public Auth Routes
// Route::get('/', [TicketController::class, 'index'])->name('home'); // Moved to auth
// Route::get('/scan', ...); // Moved to auth

use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

Route::middleware('auth')->group(function () {
    Route::post('/events/{event:slug}/checkout', [CheckoutController::class, 'store'])->name('events.checkout');
    Route::get('/tickets/{ticket:uuid}/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Auth Routes
// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        if (auth()->user()->role === 'volunteer') {
            return redirect()->route('scan');
        } elseif (auth()->user()->role === 'user') {
            return redirect()->route('user.dashboard');
        }
        return redirect()->route('admin.dashboard');
    })->name('home');

    Route::get('/my/history', [\App\Http\Controllers\MyHistoryController::class, 'index'])->name('my.history');

    Route::get('profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('profile.password');

    // User Portal
    Route::middleware(['role:user'])->prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

        Route::get('tickets', [\App\Http\Controllers\User\TicketController::class, 'index'])->name('tickets.index');
        Route::get('tickets/{ticket}', [\App\Http\Controllers\User\TicketController::class, 'show'])->name('tickets.show');

        Route::get('payments', [\App\Http\Controllers\User\PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{payment}', [\App\Http\Controllers\User\PaymentController::class, 'show'])->name('payments.show');

        Route::post('testimonials', [\App\Http\Controllers\User\TestimonialController::class, 'store'])->name('testimonials.store');
    });

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

        // Activity History
        Route::get('history', [\App\Http\Controllers\Admin\HistoryController::class, 'index'])->name('history.index');
        Route::get('history/export', [\App\Http\Controllers\Admin\HistoryController::class, 'export'])->name('history.export');
        Route::get('history/{id}', [\App\Http\Controllers\Admin\HistoryController::class, 'show'])->name('history.show');
    });

    // Admin Only Area
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // User Management
        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        // Master Data Management
        Route::resource('venues', \App\Http\Controllers\Admin\VenueController::class);
        Route::resource('venues.seats', \App\Http\Controllers\Admin\SeatController::class);
        Route::resource('organizers', \App\Http\Controllers\Admin\OrganizerController::class);
        Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
        Route::resource('events.ticket-types', \App\Http\Controllers\Admin\TicketTypeController::class);
    });

});

