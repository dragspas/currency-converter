<?php

namespace App\Services;

use App\Services\Entities\Transaction;

interface IConversionService
{
    public function convertFromDefault(int $toCurrencyId, float $amount, bool $save = false): Transaction;
}
