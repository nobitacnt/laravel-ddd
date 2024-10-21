<?php

namespace Modules\User\Domain\Exceptions;
use Modules\Shared\Domain\Exceptions\DomainException;
use Symfony\Component\HttpFoundation\Response;

final class PasswordsDoNotMatchException extends DomainException
{
    public function __construct(string $message = 'Passwords do not match')
    {
        $this->httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        parent::__construct($message);
    }
}
