<?php

namespace Modules\Product\Application\Exceptions;

use Modules\Shared\Domain\Exceptions\DomainException;
use Symfony\Component\HttpFoundation\Response;

final class ProductAlreadyUsedException extends DomainException
{
    public function __construct()
    {
        $this->httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        parent::__construct('Code is already taken!');
    }
}
