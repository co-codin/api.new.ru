<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\Admin\SeoRuleController;

Route::resource('seo_rules', SeoRuleController::class);
