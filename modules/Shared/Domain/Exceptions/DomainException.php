<?php

namespace Modules\Shared\Domain\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class DomainException extends Exception
{
    protected int $httpCode = Response::HTTP_SERVICE_UNAVAILABLE;

    public function __construct(string $message = 'Domain Related Issue.')
    {
        parent::__construct($message);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
