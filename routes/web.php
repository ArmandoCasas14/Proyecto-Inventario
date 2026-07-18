<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['role:Administrador,Encargado de Inventario'])->group(function () {
    Route::resource('categories', CategoryController::class)->names('categorias');
    Route::resource('suppliers', SupplierController::class)->names('proveedores');
    Route::resource('products', ProductController::class)->names('productos');
    Route::resource('invoices', InvoiceController::class)->names('facturas');
    Route::resource('users', UserController::class)->names('usuarios');
    Route::resource('movements', MovementController::class)->names('movimientos')->only(['index', 'create', 'store']);
    Route::patch('suppliers/{supplier}/toggle', [SupplierController::class, 'toggleStatus'])->name('proveedores.toggleStatus');
    Route::patch('categories/{category}/toggle', [CategoryController::class, 'toggleStatus'])->name('categorias.toggleStatus');
    Route::patch('products/{product}/toggle', [ProductController::class, 'toggleStatus'])->name('productos.toggleStatus');
});
});


require __DIR__.'/auth.php';
