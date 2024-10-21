<?php

namespace Modules\User\Domain\Exceptions;

use Modules\Shared\Domain\Exceptions\DomainException;
use Symfony\Component\HttpFoundation\Response;

final class PasswordTooShortException extends DomainException
{
    public function __construct(string $message = 'The password needs to be at least 8 characters long')
    {
        $this->httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        parent::__construct($message);
    }
}
