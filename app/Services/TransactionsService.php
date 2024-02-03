<?php

namespace App\Services;

use stdClass;

class TransactionsService implements ITransactionsService
{
    private ICurrenciesService $currenciesService;

    public function __construct(
        ICurrenciesService $currenciesService
    ) {
        $this->currenciesService = $currenciesService;
    }

    public function store(int $toCurrencyId, float $amount): stdClass
    {
        $conversion = $this->currenciesService->convertFromDefault($toCurrencyId, $amount);

        return (object) [
            'amount' => $conversion,
        ];
    }
}
