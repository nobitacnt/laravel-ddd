<?php
namespace Modules\Shared\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class DatabaseException extends DomainException
{
    public function __construct(string $message = 'Something went wrong with the database.')
    {
        $this->httpCode = Response::HTTP_SERVICE_UNAVAILABLE;
        parent::__construct($message);
    }
}
