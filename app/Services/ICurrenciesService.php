<?php

namespace App\Services;

use App\Enums\Db\Flag;
use Illuminate\Support\Collection;
use stdClass;

interface ICurrenciesService
{
    public function getAllByDefault(Flag $default = Flag::On): Collection;
    public function getDefault(): stdClass;
    public function convertFromDefault(int $toCurrencyId, float $amount): float;
}
