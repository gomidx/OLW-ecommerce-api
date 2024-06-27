<?php

use App\Http\Controllers\Backoffice\BrandController;
use App\Http\Controllers\Backoffice\CategoryController;
use App\Http\Controllers\Backoffice\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
});


require __DIR__.'/auth.php';
