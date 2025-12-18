<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ne pas forcer la connexion à la base de données au démarrage
        // La connexion sera établie seulement quand nécessaire
        // Cela évite de bloquer le serveur si PostgreSQL n'est pas accessible
    }
}
