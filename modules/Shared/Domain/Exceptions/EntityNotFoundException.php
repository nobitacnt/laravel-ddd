<?php

namespace Modules\Shared\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class EntityNotFoundException extends DomainException
{
    public function __construct(string $message = 'Entity not found.')
    {
        $this->httpCode = Response::HTTP_NOT_FOUND;
        parent::__construct($message);
    }
}
