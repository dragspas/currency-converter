<?php

namespace App\Services\External;

use App\Services\IProxyService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use stdClass;

class CurrencyLayerService implements ICurrencyLayerService
{
    private IProxyService $proxy;

    public function __construct(IProxyService $proxy)
    {
        $this->proxy = $proxy;
    }

    public function getLive(Collection $exchangeRates): array
    {
        $output = [];
        $grouped = $this->groupExchangeRatesByCode($exchangeRates);

        foreach ($grouped as $fromCode => $group) {
            $response = $this->makeExchangeRatesRequest($fromCode, implode(',', array_keys($group['currenciesMap'])));
            $output = array_merge($output, $this->prepareForUpdate($group['from_currency_id'], $group['currenciesMap'], $response));
        }

        return $output;
    }

    protected function prepareForUpdate(int $fromCurrencyId, array $toCurrenciesMap, stdClass $response): array
    {
        $now = Carbon::now();
        $output = [];
        foreach ($response->quotes as $key => $value) {
            // ex.: remove USD from USDEUR
            $toCode = substr($key, 3);
            $output[] = [
                'from_currency_id' => $fromCurrencyId,
                'to_currency_id' => $toCurrenciesMap[$toCode],
                'rate' => $value,
                'updated_at' => $now
            ];
        }

        return $output;
    }

    protected function makeExchangeRatesRequest(string $from, string $currencies)
    {
        $appId = config('services.currency_layer.app_id');
        $url = config('services.currency_layer.base_url');

        try {
            $result = $this->proxy->get(
                $url . 'live',
                [
                    'access_key' => $appId,
                    'source' => $from,
                    'currencies' => $currencies,
                    'format' => 1
                ],
                true
            );
            $response = $result->object();

            if (!$response->success) {
                throw new \Exception($response->error->info);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('Failed to get exchange rates.', [
                'from' => $from,
                'currencies' => $currencies,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function groupExchangeRatesByCode(Collection $exchangeRates): Collection
    {
        return $exchangeRates->groupBy('from_currency_code')->map(function ($items) {
            return [
                'from_currency_id' => $items->first()->from_currency_id,
                'currenciesMap' => $items->pluck('to_currency_id', 'to_currency_code')->toArray()
            ];
        });
    }
}
