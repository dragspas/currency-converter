<?php

namespace App\Services\Currencies;

use App\Services\Entities\Transaction;

abstract class BaseConverter
{
    public function calculate(Transaction $transaction): Transaction
    {
        $baseAmount = round($transaction->foreign_currency_amount / $transaction->exchange_rate, 2);
        $withSurcharge = round($baseAmount * (1 + $transaction->surcharge_percentage / 100), 2);

        $transaction->surcharge_amount = round($withSurcharge - $baseAmount, 2);
        $transaction->amount_paid_usd = round($withSurcharge * (1 - $transaction->discount_percentage / 100), 2);
        $transaction->discount_amount = round($withSurcharge - $transaction->amount_paid_usd, 2);

        return $transaction;
    }

    public function sendNotification(Transaction $transaction): void
    {
        // By default do nothing
    }
}
