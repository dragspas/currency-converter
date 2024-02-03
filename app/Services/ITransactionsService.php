<?php

namespace App\Services;

use App\Services\Entities\Transaction;

interface ITransactionsService
{
    public function store(Transaction $transaction): Transaction;
}
