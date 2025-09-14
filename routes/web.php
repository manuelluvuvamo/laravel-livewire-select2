<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('category', CategoryController::class)->names('category');
Route::resource('subcategory', SubcategoryController::class)->names('subcategory');
Route::resource('document', DocumentController::class)->names('document');