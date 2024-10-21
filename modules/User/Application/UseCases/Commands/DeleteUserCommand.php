<?php
namespace Modules\User\Application\UseCases\Commands;

use Modules\User\Domain\Services\UserService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;

readonly class DeleteUserCommand
{
    public function __construct(
        private UserService $userService
    )
    {}

    /**
     * @param string $id
     * @return void
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function handle(string $id): void
    {
        $this->userService->deleteUser($id);
    }
}
