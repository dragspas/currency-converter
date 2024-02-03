<?php

namespace App\Repository;

interface ITransactionsRepository
{
    public function insert(array $attributes): int;
}
