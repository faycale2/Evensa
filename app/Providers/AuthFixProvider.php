<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Auth\Access\Gate as GateImplementation; // ⚠️ pas la façade
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Auth;

class AuthFixProvider extends ServiceProvider
{
    /**
     * Enregistre le binding du Gate.
     */
    public function register(): void
    {
        $this->app->singleton(GateContract::class, function (Container $app) {
            return new GateImplementation(
                $app,                       // 1) Container
                static function () {        // 2) Résolveur utilisateur
                    return Auth::user();
                }
                // Les autres paramètres sont optionnels et gardent leurs valeurs par défaut
            );
        });
    }

    /**
     * Bootstrap des services d'authz.
     */
    public function boot(): void
    {
        // Appelle registerPolicies() si tu déclares des policies sur $policies
        if (method_exists($this, 'registerPolicies')) {
            $this->registerPolicies();
        }
    }
}
