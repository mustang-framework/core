<?php

namespace Mustang\Core\Commands;

use Mustang\Core\Abstracts\Commands\ConsoleCommand;
use Illuminate\Support\Facades\Config;

class SeedDeploymentDataCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = "mustang:seed-deploy";

    /**
     * The console command description.
     */
    protected $description = "Seed data for initial deployment.";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->call('db:seed', [
            '--class' => Config::get('mustang.seeders.deployment'),
        ]);

        $this->info('Deployment Data Seeded Successfully.');
    }
}
