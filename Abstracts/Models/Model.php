<?php

namespace Mustang\Core\Abstracts\Models;

use Mustang\Core\Traits\FactoryLocatorTrait;
use Mustang\Core\Traits\HashedRouteBindingTrait;
use Mustang\Core\Traits\HashIdTrait;
use Mustang\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelEloquentModel;

abstract class Model extends LaravelEloquentModel
{
    use HashIdTrait;
    use HashedRouteBindingTrait;
    use HasResourceKeyTrait;
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }
}
