<?php

use App\Enums\Db\Flag;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 3)->index();
            $table->tinyInteger('default')->default(Flag::Off->value);
            $table->decimal('surcharge')->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $now = Carbon::now();

        DB::table('currencies')->insert([
            ['id' => 1, 'name' => 'US Dollars', 'code' => 'USD', 'default' => Flag::On->value, 'surcharge' => null, 'discount' => null, 'created_at' => $now],
            ['id' => 2, 'name' => 'Euro', 'code' => 'EUR', 'default' => Flag::Off->value, 'surcharge' => 5, 'discount' => 2, 'created_at' => $now],
            ['id' => 3, 'name' => 'British Pound', 'code' => 'GBP', 'default' => Flag::Off->value, 'surcharge' => 5, 'discount' => null, 'created_at' => $now],
            ['id' => 4, 'name' => 'Japanese Yen', 'code' => 'JPY', 'default' => Flag::Off->value, 'surcharge' => 7.5, 'discount' => null, 'created_at' => $now],
        ]);

        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_currency_id')->constrained('currencies');
            $table->foreignId('to_currency_id')->constrained('currencies');
            $table->decimal('rate', 20, 6);
            $table->unique(['from_currency_id', 'to_currency_id']);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('exchange_rates')->insert([
            ['from_currency_id' => 1, 'to_currency_id' => 4, 'rate' => 107.17, 'created_at' => $now],
            ['from_currency_id' => 1, 'to_currency_id' => 3, 'rate' => 0.711178, 'created_at' => $now],
            ['from_currency_id' => 1, 'to_currency_id' => 2, 'rate' => 0.884872, 'created_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
        Schema::dropIfExists('currencies');
    }
};
