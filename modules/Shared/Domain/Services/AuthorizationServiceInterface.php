<?php

namespace Modules\Shared\Domain\Services;

interface AuthorizationServiceInterface
{
    public function authorize(string $ability): bool;
}
