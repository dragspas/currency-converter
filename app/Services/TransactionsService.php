<?php

namespace App\Services;

use App\Repository\ITransactionsRepository;
use App\Services\Entities\Transaction;

class TransactionsService implements ITransactionsService
{
    private ITransactionsRepository $transactionsRepository;

    public function __construct(
        ITransactionsRepository $transactionsRepository
    ) {
        $this->transactionsRepository = $transactionsRepository;
    }

    public function store(Transaction $transaction): Transaction
    {
        $transactionId = $this->transactionsRepository->insert([
            'currency_id' => $transaction->currencyId,
            'exchange_rate' => $transaction->exchangeRate,
            'surcharge_percentage' => $transaction->surchargePercentage,
            'surcharge_amount' => $transaction->surchargeAmount,
            'foreign_currency_amount' => $transaction->foreignCurrencyAmount,
            'amount_paid_usd' => $transaction->amountPaidUsd,
            'discount_percentage' => $transaction->discountPercentage,
            'discount_amount' => $transaction->discountAmount
        ]);

        $transaction->id = $transactionId;

        return $transaction;
    }
}
