<?php

namespace Modules\User\Application\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Modules\Shared\Domain\Exceptions\DomainException;

final class EmailAlreadyUsedException extends DomainException
{
    public function __construct()
    {
        $this->httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        parent::__construct('Email is already taken!');
    }
}
