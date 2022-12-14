<?php

namespace Modules\Seo\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('auth:sanctum')
            ->as('admin.')
            ->prefix('admin')
            ->group(module_path('Seo', '/Routes/admin.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->group(module_path('Seo', '/Routes/api.php'));
    }
}
