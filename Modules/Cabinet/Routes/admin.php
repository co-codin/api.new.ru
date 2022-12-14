<?php

use Illuminate\Support\Facades\Route;
use Modules\Cabinet\Http\Controllers\Admin\CabinetController;
use Modules\Cabinet\Http\Controllers\Admin\CabinetSeoController;
use Modules\Cabinet\Http\Controllers\Admin\CabinetCategoryController;
use Modules\Cabinet\Http\Controllers\Admin\CabinetDocumentController;

Route::patch('cabinets/{cabinet}/seo', [CabinetSeoController::class, 'update']);
Route::put('cabinets/{cabinet}/categories', [CabinetCategoryController::class, 'update'])->name('cabinet.categories.update');
Route::put('cabinets/{cabinet}/documents', [CabinetDocumentController::class, 'update'])->name('cabinet.documents.update');

Route::resource('cabinets', CabinetController::class)->except('index', 'show');
