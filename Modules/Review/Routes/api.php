<?php

use App\Http\Middleware\ClientAuth;
use Modules\Review\Http\Controllers\ProductReviewController;

Route::apiResource('product-reviews', ProductReviewController::class)
    ->only('index', 'show');

Route::post('product-reviews', [ProductReviewController::class, 'store'])
    ->middleware(ClientAuth::class);
