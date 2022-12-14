<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductAnswerController;
use Modules\Product\Http\Controllers\ProductAnswerRateController;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductFilterController;
use Modules\Product\Http\Controllers\ProductQuestionController;
use Modules\Product\Http\Middleware\ProductAnswerRateMiddleware;
use Modules\Product\Http\Controllers\ProductPageController;
use Modules\Product\Http\Controllers\ProductComparePageController;
use Modules\Product\Http\Controllers\ProductFavoritePageController;

Route::post('/products/filter', [ProductFilterController::class, 'index'])
    ->name('products.filter');

Route::get('/products/compare/page', [ProductComparePageController::class, 'index']);
Route::get('/products/favorite/page', [ProductFavoritePageController::class, 'index']);

Route::get('/products/{product}/page', [ProductPageController::class, 'show']);

Route::resource('products', ProductController::class)->only(['index', 'show']);


Route::apiResource('product-questions', ProductQuestionController::class)
    ->only('index', 'show', 'store');

Route::apiResource('product-answers', ProductAnswerController::class)
    ->only('index', 'show');

Route::middleware(ProductAnswerRateMiddleware::class)->group(function () {
    Route::match(['put', 'patch'], 'product-answers-rate/{product_answer}', [ProductAnswerRateController::class, 'rate'])
        ->name('product-answers.rate');
});
