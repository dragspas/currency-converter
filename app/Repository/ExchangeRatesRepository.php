<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExchangeRatesRepository extends BaseRepository implements IExchangeRatesRepository
{
    public function update(array $conditions, array $attributes): int
    {
        $builder = $this->builder;
        // make entity and validet every input

        return $builder->update($attributes);
    }

    public function getAll(int $limit, int $offset): Collection
    {

        return $this->builder
            ->select(['from_currency.code as from_currency_code', 'to_currency.code as to_currency_code'])
            ->join('currencies as from_currency', 'exchange_rates.from_currency_id', '=', 'from_currency.id')
            ->join('currencies as to_currency', 'exchange_rates.to_currency_id', '=', 'to_currency.id')
            ->whereNull('exchange_rates.deleted_at')
            ->orderBy('exchange_rates.id')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    protected function getTable(): Builder
    {
        return DB::table('exchange_rates');
    }
}
