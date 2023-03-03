<?php

namespace Mustang\Core\Providers;

use Mustang\Core\Abstracts\Providers\MainServiceProvider as AbstractMainServiceProvider;
use Mustang\Core\Foundation\Mustang;
use Mustang\Core\Loaders\AutoLoaderTrait;
use Mustang\Core\Traits\ValidationTrait;
use Illuminate\Support\Facades\Schema;

class MustangServiceProvider extends AbstractMainServiceProvider
{
    use AutoLoaderTrait;
    use ValidationTrait;

    public function register(): void
    {
        // NOTE: function order of this calls bellow are important. Do not change it.

        $this->app->bind('Mustang', Mustang::class);
        // Register Core Facade Classes, should not be registered in the $aliases property, since they are used
        // by the auto-loading scripts, before the $aliases property is executed.
        $this->app->alias(Mustang::class, 'Mustang');

        // parent::register() should be called AFTER we bind 'Mustang'
        parent::register();

        $this->runLoaderRegister();
    }

    public function boot(): void
    {
        parent::boot();

        // Autoload most of the Containers and Ship Components
        $this->runLoadersBoot();

        // Solves the "specified key was too long" error, introduced in L5.4
        Schema::defaultStringLength(191);

        // Registering custom validation rules
        $this->extendValidationRules();
    }
}
