<?php

namespace App\Providers;

use App\Repositories\GrupoRepository;
use App\Repositories\PedidoRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\GenericoRepository;
use App\Domain\Interfaces\IGrupoRepository;
use App\Domain\Interfaces\IPedidoRepository;
use App\Domain\Interfaces\IGenericoRepository;

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
        //
        // Registando as injecoes de dependencia na aplicacao
        $this->app->bind(IGenericoRepository::class, GenericoRepository::class);
        $this->app->bind(IGrupoRepository::class, GrupoRepository::class);
        $this->app->bind(IPedidoRepository::class, PedidoRepository::class);
    }
}
