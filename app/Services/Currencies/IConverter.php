<?php

namespace App\Services\Currencies;

use App\Services\Entities\Transaction;

interface IConverter
{
    public function calculate(Transaction $transaction): Transaction;
    public function sendNotification(Transaction $transaction): void;
}
