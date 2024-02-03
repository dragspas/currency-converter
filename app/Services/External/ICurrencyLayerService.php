<?php

namespace App\Services\External;

use Illuminate\Support\Collection;

interface ICurrencyLayerService
{
    public function getLive(Collection $exchangeRatesToUpdate): array;
}
