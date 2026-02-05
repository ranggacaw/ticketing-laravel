<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;

Route::get('/', [TicketController::class, 'index'])->name('home');
Route::get('/scan', [TicketController::class, 'scan'])->name('scan');
Route::post('/validate', [TicketController::class, 'validateTicket'])->name('validate');
Route::get('/result/{status}', [TicketController::class, 'result'])->name('result');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class);
    Route::get('tickets/{ticket}/export', [\App\Http\Controllers\Admin\TicketController::class, 'export'])->name('tickets.export');
});

