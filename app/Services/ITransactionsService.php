<?php

namespace App\Services;

use stdClass;

interface ITransactionsService
{
    public function store(int $toCurrencyId, float $amount): stdClass;
}
