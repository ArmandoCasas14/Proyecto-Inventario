<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Contollers\Api\ProveedorController;

Route::apiResource('proveedores', ProveedorController::class);
