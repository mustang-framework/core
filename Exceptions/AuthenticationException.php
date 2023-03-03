<?php

namespace Mustang\Core\Exceptions;

use Mustang\Core\Abstracts\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends Exception
{
    protected $code = Response::HTTP_UNAUTHORIZED;
    protected $message = 'An Exception occurred while trying to authenticate the User.';
}
