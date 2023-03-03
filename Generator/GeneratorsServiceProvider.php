<?php

namespace Mustang\Core\Generator;

use Mustang\Core\Generator\Commands\ActionGenerator;
use Mustang\Core\Generator\Commands\ConfigurationGenerator;
use Mustang\Core\Generator\Commands\ContainerApiGenerator;
use Mustang\Core\Generator\Commands\ContainerGenerator;
use Mustang\Core\Generator\Commands\ContainerWebGenerator;
use Mustang\Core\Generator\Commands\ControllerGenerator;
use Mustang\Core\Generator\Commands\EventGenerator;
use Mustang\Core\Generator\Commands\EventListenerGenerator;
use Mustang\Core\Generator\Commands\ExceptionGenerator;
use Mustang\Core\Generator\Commands\JobGenerator;
use Mustang\Core\Generator\Commands\MailGenerator;
use Mustang\Core\Generator\Commands\MiddlewareGenerator;
use Mustang\Core\Generator\Commands\MigrationGenerator;
use Mustang\Core\Generator\Commands\ModelFactoryGenerator;
use Mustang\Core\Generator\Commands\ModelGenerator;
use Mustang\Core\Generator\Commands\NotificationGenerator;
use Mustang\Core\Generator\Commands\PolicyGenerator;
use Mustang\Core\Generator\Commands\ReadmeGenerator;
use Mustang\Core\Generator\Commands\RepositoryGenerator;
use Mustang\Core\Generator\Commands\RequestGenerator;
use Mustang\Core\Generator\Commands\RouteGenerator;
use Mustang\Core\Generator\Commands\SeederGenerator;
use Mustang\Core\Generator\Commands\ServiceProviderGenerator;
use Mustang\Core\Generator\Commands\SubActionGenerator;
use Mustang\Core\Generator\Commands\TaskGenerator;
use Mustang\Core\Generator\Commands\TestFunctionalTestGenerator;
use Mustang\Core\Generator\Commands\TestTestCaseGenerator;
use Mustang\Core\Generator\Commands\TestUnitTestGenerator;
use Mustang\Core\Generator\Commands\TransformerGenerator;
use Mustang\Core\Generator\Commands\ValueGenerator;
use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->getGeneratorCommands());
        }
    }

    private function getGeneratorCommands(): array
    {
        // add your generators here
        return $generatorCommands = [
            ActionGenerator::class,
            ConfigurationGenerator::class,
            ContainerGenerator::class,
            ContainerApiGenerator::class,
            ContainerWebGenerator::class,
            ControllerGenerator::class,
            EventGenerator::class,
            EventListenerGenerator::class,
            ExceptionGenerator::class,
            JobGenerator::class,
            ModelFactoryGenerator::class,
            MailGenerator::class,
            MiddlewareGenerator::class,
            MigrationGenerator::class,
            ModelGenerator::class,
            NotificationGenerator::class,
            PolicyGenerator::class,
            ReadmeGenerator::class,
            RepositoryGenerator::class,
            RequestGenerator::class,
            RouteGenerator::class,
            SeederGenerator::class,
            ServiceProviderGenerator::class,
            SubActionGenerator::class,
            TestFunctionalTestGenerator::class,
            TestTestCaseGenerator::class,
            TestUnitTestGenerator::class,
            TaskGenerator::class,
            TransformerGenerator::class,
            ValueGenerator::class,
        ];
    }
}
