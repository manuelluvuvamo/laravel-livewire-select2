<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->prefix('v1')->name('api.')->group(function () {
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('subcategory', [SubcategoryController::class, 'index'])->name('subcategory.index');
});
