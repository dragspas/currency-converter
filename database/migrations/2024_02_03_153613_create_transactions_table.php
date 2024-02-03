<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // @note
        // this table could be huge if we plan to support millions of transactions
        // one of ideas how to optimize it is table partitioning
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->constrained('currencies');
            $table->decimal('exchange_rate', 20, 6);
            $table->decimal('surcharge_percentage');
            $table->decimal('surcharge_amount', 10, 2);
            $table->decimal('foreign_currency_amount', 10, 2);
            $table->decimal('amount_paid_usd', 10, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
