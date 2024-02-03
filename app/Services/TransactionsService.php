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
            'currency_id' => $transaction->currency_id,
            'exchange_rate' => $transaction->exchange_rate,
            'surcharge_percentage' => $transaction->surcharge_percentage,
            'surcharge_amount' => $transaction->surcharge_amount,
            'foreign_currency_amount' => $transaction->foreign_currency_amount,
            'amount_paid_usd' => $transaction->amount_paid_usd,
            'discount_percentage' => $transaction->discount_percentage,
            'discount_amount' => $transaction->discount_amount
        ]);

        $transaction->id = $transactionId;

        return $transaction;
    }
}
