<?php

namespace App\Services;

use App\Services\Entities\Transaction;
use stdClass;

interface ITransactionsService
{
    public function store(Transaction $transaction): Transaction;
}
