<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Livewire\ShowCustomers;
use App\Livewire\CreateOrder;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

// Protected Routes (Must be logged in to access)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Customer Management (Livewire)
    // This loads your new list/add/delete page while keeping the sidebar
    // Existing route
    
    Route::get('/users', \App\Livewire\UserManagement::class)->name('users.index');
    Route::get('/customers', ShowCustomers::class)->name('customers.index');
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'show'])->name('orders.invoice');
    Route::get('/orders/{order}/namelist', [InvoiceController::class, 'namelist'])->name('orders.namelist');
    // NEW ROUTE: View Specific Customer Details
    Route::get('/customers/{id}', \App\Livewire\CustomerDetails::class)->name('customers.show');
    // 3. Order Management (Livewire)
    Route::get('/orders/create', CreateOrder::class)->name('orders.create');
    Route::get('/production', \App\Livewire\ProductionStatus::class)->name('production.index');
    
    Route::get('/analytics', \App\Livewire\Analytic::class)->name('analytics.index');
    // 4. Calendar API Routes (Backend for Dashboard Calendar)
    Route::get('/events', [EventController::class, 'getEvents']);
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
});