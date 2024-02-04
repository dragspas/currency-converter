<?php

namespace App\Repository;

use App\Enums\Db\Flag;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

class CurrenciesRepository extends BaseRepository implements ICurrenciesRepository
{
    public function getDefault(): stdClass
    {
        return $this->getAll(['default' => Flag::On->value])->first();
    }

    public function getAll(array $conditions = [], array $columns = ['*']): Collection
    {
        $builder = $this->getBuilder();

        $builder->select($columns);

        foreach ($conditions as $key => $value) {
            $builder->where($key, $value);
        }

        return $builder->get();
    }

    public function getDefaultWithExchangeRate(int $toCurrencyId): stdClass
    {
        $result = $this->getBuilder()
            ->select([
                'currencies.id',
                'currencies.code',
                'exchange_rates.rate',
                'to_currency.code as to_currency_code',
                'to_currency.surcharge',
                'to_currency.discount',
            ])
            ->join('exchange_rates', function ($join) use ($toCurrencyId) {
                $join
                    ->on('currencies.id', '=', 'exchange_rates.from_currency_id')
                    ->join('currencies as to_currency', function ($join) {
                        $join
                            ->on('exchange_rates.to_currency_id', 'to_currency.id')
                            ->select(['to_currency.surcharge', 'to_currency.discount']);
                    })
                    ->where('exchange_rates.to_currency_id', $toCurrencyId)
                    ->whereNull('exchange_rates.deleted_at');
            })
            ->get();

        if ($result->isEmpty()) {
            throw new \Exception('Exchange rate for this conversion not found.', 204);
        }

        return $result->first();
    }

    protected function getTable(): Builder
    {
        return DB::table('currencies');
    }
}
