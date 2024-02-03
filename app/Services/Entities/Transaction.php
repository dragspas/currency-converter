<?php

namespace App\Services\Entities;

class Transaction
{
    public ?int $id = null;
    public int $currency_id;
    public float $exchange_rate;
    public float $surcharge_percentage;
    public float $surcharge_amount;
    public float $foreign_currency_amount;
    public float $amount_paid_usd;
    public float $discount_percentage;
    public float $discount_amount;
}
