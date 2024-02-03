<?php

namespace App\Repository;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TransactionsRepository extends BaseRepository implements ITransactionsRepository
{
    protected function getTable(): Builder
    {
        return DB::table('transactions');
    }
}
