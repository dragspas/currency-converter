<?php

namespace App\Repository;;

use Illuminate\Database\Query\Builder;
use stdClass;

abstract class BaseRepository
{
    private Builder $builder;

    public function __construct()
    {
        $this->builder = $this->getTable();
    }

    abstract protected function getTable(): Builder;

    protected function getBuilder(): Builder
    {
        return $this->builder->clone();
    }
}
