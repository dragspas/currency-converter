<?php

namespace App\Services;

use App\Repository\ICurrenciesRepository;

class CurrenciesService implements ICurrenciesService
{
    private ICurrenciesRepository $repository;

    public function __construct(
        ICurrenciesRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getDefault()
    {
        return $this->repository->getDefault();
    }
}
