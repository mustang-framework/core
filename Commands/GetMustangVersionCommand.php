<?php

namespace Mustang\Core\Commands;

use Mustang\Core\Abstracts\Commands\ConsoleCommand;
use Mustang\Core\Foundation\Mustang;

class GetMustangVersionCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = "mustang";

    /**
     * The console command description.
     */
    protected $description = "Display the current Mustang version.";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info(Mustang::VERSION);
    }
}
