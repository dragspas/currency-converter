<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface IExchangeRatesRepository
{
    public function getAll(int $limit, int $offset): Collection;
    public function update(array $conditions, array $attributes): int;
}
