<?php

namespace App\Services\Currencies;

use App\Services\Entities\Transaction;

class BritishPoundConverter extends BaseConverter implements IConverter
{
    public function sendNotification(Transaction $transaction): void
    {
        // prepare details
        // send messesage to queue
        // queue will send notification
    }
}
