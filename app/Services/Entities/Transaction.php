<?php

namespace App\Services\Entities;

class Transaction
{
    public int $currencyId;
    public float $exchangeRate;
    public float $foreignCurrencyAmount;
    public float $surchargePercentage = 0.0;
    public float $discountPercentage = 0.0;
    public ?int $id = null;
    public ?float $surchargeAmount = null;
    public ?float $amountPaidUsd = null;
    public ?float $discountAmount = null;

    public function __construct(int $currencyId, float $exchangeRate, float $foreignCurrencyAmount)
    {
        $this->currencyId = $currencyId;
        $this->exchangeRate = $exchangeRate;
        $this->foreignCurrencyAmount = $foreignCurrencyAmount;
    }
}
