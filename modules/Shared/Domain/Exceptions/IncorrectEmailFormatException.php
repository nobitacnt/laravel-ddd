<?php

namespace Modules\Shared\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class IncorrectEmailFormatException extends DomainException
{
    public function __construct(string $message = 'Email is not valid.')
    {
        $this->httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        parent::__construct($message);
    }
}
