<?php

namespace App\Services\Currencies;

use App\Enums\CurrencyName;
use App\Services\Entities\Transaction;

class ConverterContext
{
    private IConverter $converter;

    public function setConverter(CurrencyName $currency): void
    {
        switch ($currency) {
            case CurrencyName::Euro:
                $converter = new EuroConverter();
                break;
            case CurrencyName::BritishPound:
                $converter = new BritishPoundConverter();
                break;
            case CurrencyName::JapaneseYen:
                $converter = new JapaneseYenConverter();
                break;
            default:
                throw new \Exception('Currency not found.', 400);
        }

        $this->converter = $converter;
    }

    public function calculate(Transaction $transaction): Transaction
    {
        return $this->converter->calculate($transaction);
    }

    public function sendNotification(Transaction $transaction): void
    {
        $this->converter->sendNotification($transaction);
    }
}
