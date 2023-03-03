<?php

namespace Mustang\Core\Exceptions;

use Mustang\Core\Abstracts\Exceptions\Exception;
use Mustang\Core\Abstracts\Transformers\Transformer;
use Symfony\Component\HttpFoundation\Response;

class InvalidTransformerException extends Exception
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
    protected $message = 'Transformers must extended the ' . Transformer::class . ' class.';
}
