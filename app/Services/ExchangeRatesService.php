<?php

namespace App\Services;

use App\Repository\IExchangeRatesRepository;
use App\Services\External\ICurrencyLayerService;
use Illuminate\Support\Facades\Log;

class ExchangeRatesService implements IExchangeRatesService
{
    private IExchangeRatesRepository $repository;
    private ICurrencyLayerService $currencyLayerExternalService;

    public function __construct(
        IExchangeRatesRepository $repository,
        ICurrencyLayerService $currencyLayerExternalService
    ) {
        $this->repository = $repository;
        $this->currencyLayerExternalService = $currencyLayerExternalService;
    }

    public function updateAll(): void
    {
        try {
            $limit = 100; // @note could be moved in some config file
            $offset = 0;
            $exchangeRatesToUpdate = collect();
            do {
                // @note 
                // to improve scalability and speed up process, 
                // we could here create message with limit/offset and send it to queue
                // in that case, we could parrallelize the process
                // but for simplicity, I will do chunk by chunk
                $exchangeRatesToUpdate = $this->repository->getAll($limit, $offset);
                $dataForUpdate = $this->currencyLayerExternalService->getLive($exchangeRatesToUpdate);

                // @note
                // DB transnsaction did not used on purpose
                // so we could keep progress in case of errors
                // I have suggested one more condition for getAll query
                // so if we run command second time, it will just continue where previous stopped
                foreach ($dataForUpdate as $data) {
                    $this->repository->update([
                        'from_currency_id' => $data['from_currency_id'],
                        'to_currency_id' => $data['to_currency_id']
                    ], [
                        'rate' => $data['rate'],
                        'updated_at' => $data['updated_at']
                    ]);
                }
                $offset += $limit;
            } while ($exchangeRatesToUpdate->count() === $limit);
        } catch (\Exception $e) {
            // @note 
            // Error messages (text) could be in separate file
            Log::error('Failed to update exchange rates.', [
                'offset' => $offset,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Failed to update exchange rates.');
        }
    }
}
