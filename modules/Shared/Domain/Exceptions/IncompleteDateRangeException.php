<?php
namespace Modules\Shared\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class IncompleteDateRangeException extends DomainException
{
    public function __construct(string $message = 'From date and to date must be provided together.')
    {
        $this->httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        parent::__construct($message);
    }
}
