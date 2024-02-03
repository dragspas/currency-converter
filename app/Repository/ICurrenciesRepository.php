<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use stdClass;

interface ICurrenciesRepository
{
    public function getAll(array $conditions = [], array $columns = ['*']): Collection;
    public function getDefault(): stdClass;
    public function getDefaultWithExchangeRate(int $toCurrencyId): stdClass;
}
