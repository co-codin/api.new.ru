<?php

use App\Http\Middleware\ClientFormAuth;
use Modules\Form\Http\Controllers\FormController;

Route::prefix('form')->group(function () {
    Route::post('/vacancy/send', [FormController::class, 'vacancy']);
    Route::post('/{formName}/send', function (string $formName) {
        $actionName = Str::camel($formName);
        $controller = App::make(FormController::class);

        if (method_exists(FormController::class, $actionName)) {
            return App::call([$controller, $actionName]);
        }

        return App::call([$controller, 'send']);
    })
        ->middleware(ClientFormAuth::class)
        ->where('formName', '[a-z0-9_-]+')
        ->name('form-send');
});
