<?php

namespace App\Providers;

use App\Repository\CurrenciesRepository;
use App\Repository\ExchangeRatesRepository;
use App\Repository\ICurrenciesRepository;
use App\Repository\IExchangeRatesRepository;
use App\Repository\ITransactionsRepository;
use App\Repository\TransactionsRepository;
use App\Services\IExchangeRatesService;
use App\Services\ExchangeRatesService;
use App\Services\ICurrenciesService;
use App\Services\CurrenciesService;
use App\Services\External\ICurrencyLayerService;
use App\Services\External\CurrencyLayerService;
use App\Services\IConversionService;
use App\Services\ConversionService;
use App\Services\IProxyService;
use App\Services\ITransactionsService;
use App\Services\ProxyService;
use App\Services\TransactionsService;
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
        $this->app->bind(ITransactionsRepository::class, TransactionsRepository::class);

        // services
        $this->app->bind(IConversionService::class, ConversionService::class);
        $this->app->bind(ICurrenciesService::class, CurrenciesService::class);
        $this->app->bind(ICurrencyLayerService::class, CurrencyLayerService::class);
        $this->app->bind(IExchangeRatesService::class, ExchangeRatesService::class);
        $this->app->bind(IProxyService::class, ProxyService::class);
        $this->app->bind(ITransactionsService::class, TransactionsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
