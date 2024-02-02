<?php

namespace App\Repository;;

use Illuminate\Database\Query\Builder;

abstract class BaseRepository
{
    protected Builder $builder;

    public function __construct()
    {
        $this->builder = $this->getTable();
    }

    abstract protected function getTable(): Builder;
}
