<?php

namespace App\Services\Currencies;

use App\Mail\SuccessfulTransaction;
use App\Services\Entities\Transaction;
use Illuminate\Support\Facades\Mail;

class BritishPoundConverter extends BaseConverter implements IConverter
{
    public function sendNotification(Transaction $transaction): void
    {
        $to = config('app.email_to_notify');

        Mail::to($to)->queue(new SuccessfulTransaction($transaction->id, $transaction->amountPaidUsd));
    }
}
