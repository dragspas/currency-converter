<?php

namespace App\Repository;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExchangeRatesRepository extends BaseRepository implements IExchangeRatesRepository
{
    public function update(array $conditions, array $attributes): int
    {
        $builder = $this->getBuilder();
        // @note
        // we could add here one validation step, to assert columns existence
        // also instead of usinf arrays, could be Entity class
        // to keep it simple, will not implement Entity classes
        // but we could discuss my ideas
        foreach ($conditions as $key => $value) {
            $builder->where($key, $value);
        }

        return $builder->update($attributes);
    }

    public function getAll(int $limit, int $offset): Collection
    {
        $builder = $this->getBuilder();

        // @note
        // Instead of retirning collection of objects type stdClass
        // could be implemented Entity class serialization
        // to be more type strict
        return $builder
            ->select([
                'exchange_rates.from_currency_id',
                'from_currency.code as from_currency_code',
                'exchange_rates.to_currency_id',
                'to_currency.code as to_currency_code'
            ])
            ->join('currencies as from_currency', 'exchange_rates.from_currency_id', '=', 'from_currency.id')
            ->join('currencies as to_currency', 'exchange_rates.to_currency_id', '=', 'to_currency.id')
            // @note
            // here could also be some condition to filter records recently updated
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
