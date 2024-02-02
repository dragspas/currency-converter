<?php

namespace App\Console\Commands;

use App\Services\IExchangeRatesService;
use Illuminate\Console\Command;

class UpdateExchangeRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(IExchangeRatesService $service)
    {
        $this->info('Updating exchange rates...');
        $service->update();
        $this->info('Done!');
    }
}
