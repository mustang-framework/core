<?php

namespace Mustang\Core\Abstracts\Models;

use Mustang\Core\Traits\FactoryLocatorTrait;
use Mustang\Core\Traits\HashedRouteBindingTrait;
use Mustang\Core\Traits\HashIdTrait;
use Mustang\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as LaravelAuthenticatableUser;

abstract class UserModel extends LaravelAuthenticatableUser
{
    use HashIdTrait;
    use HashedRouteBindingTrait;
    use HasResourceKeyTrait;
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }
}
