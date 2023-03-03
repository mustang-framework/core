<?php

namespace Mustang\Core\Exceptions;

use Mustang\Core\Abstracts\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class IncorrectIdException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
    protected $message = 'ID input is incorrect.';
}
