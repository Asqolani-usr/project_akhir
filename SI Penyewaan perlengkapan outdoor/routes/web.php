<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GearController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\TransactionController as CustomerTransaction;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\GearController as AdminGear;
use App\Http\Controllers\Admin\LeaderController as AdminLeader;
use App\Http\Controllers\Admin\TransactionController as AdminTransaction;
use App\Http\Controllers\Admin\CustomerController as AdminCustomer;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\CalendarController as AdminCalendar;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gear', [GearController::class, 'index'])->name('gear.index');

/*
|--------------------------------------------------------------------------
| Cart API (AJAX — session-based, no auth required)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update', [CartController::class, 'update'])->name('update');
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

/*
|--------------------------------------------------------------------------
| Auth Required Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    /*
    |----------------------------------------------------------------------
    | Customer Routes
    |----------------------------------------------------------------------
    */
    Route::middleware('role:customer')->prefix('dashboard')->name('customer.')->group(function () {
        Route::get('/', [CustomerDashboard::class, 'index'])->name('dashboard');
        Route::get('/transactions', [CustomerTransaction::class, 'index'])->name('transactions');
        Route::get('/transactions/{transaction}', [CustomerTransaction::class, 'show'])->name('transactions.show');
        Route::get('/payment/{transaction}', [PaymentController::class, 'show'])->name('payment');
        Route::post('/payment/{transaction}', [PaymentController::class, 'upload'])->name('payment.upload');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });

    // Notification count API (AJAX)
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');

    /*
    |----------------------------------------------------------------------
    | Admin Routes
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

        // Inventory
        Route::get('/inventory', [AdminGear::class, 'index'])->name('inventory');
        Route::post('/inventory', [AdminGear::class, 'store'])->name('inventory.store');
        Route::put('/inventory/{gear}', [AdminGear::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{gear}', [AdminGear::class, 'destroy'])->name('inventory.destroy');

        // Leaders
        Route::get('/leaders', [AdminLeader::class, 'index'])->name('leaders');
        Route::post('/leaders', [AdminLeader::class, 'store'])->name('leaders.store');
        Route::put('/leaders/{leader}', [AdminLeader::class, 'update'])->name('leaders.update');
        Route::delete('/leaders/{leader}', [AdminLeader::class, 'destroy'])->name('leaders.destroy');

        // Transactions
        Route::get('/transactions', [AdminTransaction::class, 'index'])->name('transactions');
        Route::put('/transactions/{transaction}/status', [AdminTransaction::class, 'updateStatus'])->name('transactions.updateStatus');

        // Customers
        Route::get('/customers', [AdminCustomer::class, 'index'])->name('customers');

        // Reports
        Route::get('/reports', [AdminReport::class, 'index'])->name('reports');

        // Calendar
        Route::get('/calendar', [AdminCalendar::class, 'index'])->name('calendar');
    });
});

require __DIR__.'/auth.php';
