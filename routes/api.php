<?php
use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceItemController;
use App\Http\Controllers\Api\MovementController;
use App\Http\Controllers\Api\MovementTypeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SupplierController;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});
Route::apiResource('categories', CategoryController::class);
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('invoice-items', InvoiceItemController::class);
Route::apiResource('movement', MovementController::class);
Route::apiResource('movement-type', MovementTypeController::class);
Route::apiResource('product', ProductController::class);
Route::apiResource('role', RoleController::class);
Route::apiResource('supplier', SupplierController::class);