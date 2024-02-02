<?php

namespace App\Providers;

use App\Repository\CurrenciesRepository;
use App\Repository\ExchangeRatesRepository;
use App\Repository\ICurrenciesRepository;
use App\Repository\IExchangeRatesRepository;
use App\Services\IExchangeRatesService;
use App\Services\ExchangeRatesService;
use App\Services\ICurrenciesService;
use App\Services\CurrenciesService;
use App\Services\IProxyService;
use App\Services\ProxyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // repositories
        $this->app->bind(ICurrenciesRepository::class, CurrenciesRepository::class);
        $this->app->bind(IExchangeRatesRepository::class, ExchangeRatesRepository::class);

        // services
        $this->app->bind(ICurrenciesService::class, CurrenciesService::class);
        $this->app->bind(IExchangeRatesService::class, ExchangeRatesService::class);
        $this->app->bind(IProxyService::class, ProxyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
