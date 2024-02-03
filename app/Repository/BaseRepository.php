<?php

namespace App\Repository;

use Illuminate\Database\Query\Builder;

abstract class BaseRepository
{
    private Builder $builder;

    public function __construct()
    {
        $this->builder = $this->getTable();
    }

    abstract protected function getTable(): Builder;

    public function insert(array $attributes): int
    {
        return $this->getBuilder()->insertGetId($attributes);
    }

    protected function getBuilder(): Builder
    {
        return $this->builder->clone();
    }
}
