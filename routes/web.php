<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OtpVerificationController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/otp-verify', [OtpVerificationController::class, 'show'])->name('otp.verify');
Route::post('/otp-verify', [OtpVerificationController::class, 'verify'])->name('otp.verify.post');
Route::post('/otp-resend', [OtpVerificationController::class, 'resend'])->name('otp.resend');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::middleware(['role:Administrador,Encargado de inventario'])->group(function () {
            Route::post('/notifications/mark-as-read', function () {
                auth()->user()->unreadNotifications->markAsRead();
                return back();
                })->middleware('auth')->name('notifications.markAsRead');
            Route::resource('categories', CategoryController::class)->names('categorias');
            Route::resource('suppliers', SupplierController::class)->names('proveedores');
            Route::get('products/export-pdf', [ProductController::class, 'exportPdf'])->name('productos.export-pdf');
            Route::resource('products', ProductController::class)->names('productos');
            Route::resource('invoices', InvoiceController::class)->names('facturas');
            Route::resource('users', UserController::class)->names('usuarios');
            Route::resource('movements', MovementController::class)->names('movimientos')->only(['index', 'create', 'store']);
            Route::patch('suppliers/{supplier}/toggle', [SupplierController::class, 'toggleStatus'])->name('proveedores.toggleStatus');
            Route::patch('categories/{category}/toggle', [CategoryController::class, 'toggleStatus'])->name('categorias.toggleStatus');
            Route::patch('products/{product}/toggle', [ProductController::class, 'toggleStatus'])->name('productos.toggleStatus');
                Route::middleware(['role:Administrador'])->group(function () {
                    Route::resource('users', UserController::class)->names('usuarios');
                });
        });
});



require __DIR__.'/auth.php';
