<?php

namespace App\Services;

use App\Repository\ICurrencyRepository;
use App\Repository\IExchangeRatesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExchangeRatesService implements IExchangeRatesService
{
    private IExchangeRatesRepository $repository;
    private ICurrenciesService $currenciesService;
    private IProxyService $proxy;


    public function __construct(
        IExchangeRatesRepository $repository,
        ICurrenciesService $currenciesService,
        IProxyService $proxy
    ) {
        $this->repository = $repository;
        $this->currenciesService = $currenciesService;
        $this->proxy = $proxy;
    }

    public function update(): void
    {
        try {
            $limit = 100;
            $offset = 0;
            $exchangeRatesToUpdate = collect();
            do {
                $exchangeRatesToUpdate = $this->repository->getAll($limit, $offset);
                dd($exchangeRatesToUpdate);
                $offset += $limit;
            } while ($exchangeRatesToUpdate->count() > 0);

            $response = $this->proxy->get('http://apilayer.net/api/live?access_key=e43197d820694747a91b24dad9f7b882&currencies=EUR,GBP,CAD,PLN&source=USD&format=1');
            dd($response->object());

            DB::beginTransaction();
            // save to DB

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            dd($e->getMessage());
        }
    }
}
