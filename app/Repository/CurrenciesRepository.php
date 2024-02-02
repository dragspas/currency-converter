<?php

namespace App\Repository;

use App\Enums\Db\Flag;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CurrenciesRepository extends BaseRepository implements ICurrenciesRepository
{
    public function getDefault()
    {
        return $this->builder
            ->where('default', Flag::On->value)
            ->first();
    }

    protected function getTable(): Builder
    {
        return DB::table('currencies');
    }
}
