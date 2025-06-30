<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public static function redirectToBasedOnRole($user)
{
    return match ($user->role) {
        'student' => '/student/dashboard',
        'lecturer' => '/lecturer/dashboard',
        default => '/dashboard',
    };
}
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
