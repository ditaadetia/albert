<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
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
        Paginator::useBootstrap();
        Gate::define('admin', function(User $user) {
            return $user->jabatan === 'admin';
        });
        Gate::define('kepala_uptd', function(User $user) {
            return $user->jabatan === 'kepala uptd';
        });
        Gate::define('kepala_dinas', function(User $user) {
            return $user->jabatan === 'kepala dinas';
        });
        Gate::define('bendahara', function(User $user) {
            return $user->jabatan === 'bendahara';
        });
        Gate::define('admin_kepalauptd', function(User $user) {
            return $user->jabatan === 'admin' || $user->jabatan === 'kepala uptd';
        });
        Gate::define('admin_kepalauptd_kepaladinas', function(User $user) {
            return $user->jabatan === 'admin' || $user->jabatan === 'kepala uptd' || $user->jabatan === 'kepala dinas';
        });
    }
}
