<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

//        Auth::viaRequest('custom-token', function (Request $request) {
//            $token = session()->get('access_token');
//
//            $response = Http::withToken($token)->get(config('services.auth.url') . '/api/auth/user');
//
//            return $response->json();
//        });
    }
}
