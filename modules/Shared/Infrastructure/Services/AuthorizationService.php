<?php
namespace Modules\Shared\Infrastructure\Services;

use Illuminate\Support\Facades\Gate;
use Modules\Shared\Domain\Services\AuthorizationServiceInterface;
use Modules\Shared\Domain\Exceptions\UnauthorizedUserException;

class AuthorizationService implements AuthorizationServiceInterface
{
    public function authorize(string $ability): bool
    {
        if(!Gate::allows($ability)) {
            throw new UnauthorizedUserException();
        }

        return true;
    }
}
