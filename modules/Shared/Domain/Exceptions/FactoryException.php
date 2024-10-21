<?php

namespace Modules\Shared\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class FactoryException extends DomainException
{
    public function __construct(string $message = 'Something is wrong with the factory.')
    {
        $this->httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        parent::__construct($message);
    }
}
