<?php

namespace Mustang\Core\Commands;

use Mustang\Core\Abstracts\Commands\ConsoleCommand;
use Illuminate\Support\Facades\Config;

class SeedTestingDataCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = "mustang:seed-test";

    /**
     * The console command description.
     */
    protected $description = "Seed testing data.";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->call('db:seed', [
            '--class' => Config::get('mustang.seeders.testing'),
        ]);

        $this->info('Testing Data Seeded Successfully.');
    }
}
