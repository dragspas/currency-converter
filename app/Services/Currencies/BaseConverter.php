<?php

namespace App\Services\Currencies;

use App\Services\Entities\Transaction;

abstract class BaseConverter
{
    public function calculate(Transaction $transaction): Transaction
    {
        $baseAmount = round($transaction->foreignCurrencyAmount / $transaction->exchangeRate, 2);
        $withSurcharge = round($baseAmount * (1 + $transaction->surchargePercentage / 100), 2);

        $transaction->surchargeAmount = round($withSurcharge - $baseAmount, 2);
        $transaction->amountPaidUsd = round($withSurcharge * (1 - $transaction->discountPercentage / 100), 2);
        $transaction->discountAmount = round($withSurcharge - $transaction->amountPaidUsd, 2);

        return $transaction;
    }

    public function sendNotification(Transaction $transaction): void
    {
        // By default do nothing
    }
}
