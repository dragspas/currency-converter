<?php

namespace App\Services;

use App\Enums\CurrencyName;
use App\Services\Currencies\ConverterContext;
use App\Services\Entities\Transaction;

class ConversionService implements IConversionService
{
    private ICurrenciesService $currenciesService;
    private ITransactionsService $transactionsService;
    private ConverterContext $converterContext;

    public function __construct(
        ICurrenciesService $currenciesService,
        ITransactionsService $transactionsService,
        ConverterContext $converterContext
    ) {
        $this->currenciesService = $currenciesService;
        $this->transactionsService = $transactionsService;
        $this->converterContext = $converterContext;
    }

    public function convertFromDefault(int $toCurrencyId, float $amount, bool $save = false): Transaction
    {
        $conversionDetails = $this->currenciesService->getDefaultWithExchangeRate($toCurrencyId);
        $this->converterContext->setConverter(CurrencyName::from($conversionDetails->to_currency_code));

        $transaction = new Transaction();
        $transaction->currency_id = $toCurrencyId;
        $transaction->exchange_rate = $conversionDetails->rate;
        $transaction->surcharge_percentage = $conversionDetails->surcharge ?? 0.00;
        $transaction->foreign_currency_amount = $amount;
        $transaction->discount_percentage = $conversionDetails->discount ?? 0.00;

        $transaction = $this->converterContext->calculate($transaction);

        if ($transaction->amount_paid_usd === 0.00) {
            throw new \Exception('Conversion amount is to small.', 201);
        }

        if ($save) {
            // $this->transactionsService->store($toCurrencyId, $transaction->amount_paid_usd);
            // $this->converterContext->sendNotification($transaction);
        }

        return $transaction;
    }
}
