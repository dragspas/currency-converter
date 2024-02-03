<?php

namespace App\Services;

use App\Enums\Db\Flag;
use App\Repository\ICurrenciesRepository;
use Illuminate\Support\Collection;
use stdClass;

class CurrenciesService implements ICurrenciesService
{
    private ICurrenciesRepository $repository;

    public function __construct(
        ICurrenciesRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getDefault(): stdClass
    {
        return $this->repository->getDefault();
    }

    public function getAllByDefault(Flag $default = Flag::On): Collection
    {
        $conditions = ['default' => $default->value];
        $columns = ['id', 'code', 'name', 'default'];

        $result = $this->repository->getAll($conditions, $columns);

        if ($result->isEmpty()) {
            throw new \Exception('Currencies not found.', 204);
        }

        return $result;
    }

    public function getDefaultWithExchangeRate(int $toCurrencyId): stdClass
    {
        return $this->repository->getDefaultWithExchangeRate($toCurrencyId);
    }
}
