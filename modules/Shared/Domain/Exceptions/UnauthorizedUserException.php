<?php

namespace Modules\Shared\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class UnauthorizedUserException extends DomainException
{
    public function __construct(string $message = 'The user is not authorized to access this resource or perform this action')
    {
        $this->httpCode = Response::HTTP_UNAUTHORIZED;
        parent::__construct($message);
    }
}
