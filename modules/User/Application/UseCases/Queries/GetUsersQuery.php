<?php
namespace Modules\User\Application\UseCases\Queries;
use Modules\User\Application\DTOs\UserDTO;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\Services\UserService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
readonly class GetUsersQuery
{
    public function __construct(
        private UserService $userService
    ){}

    /**
     * @param UserDTO $userDTO
     * @return UserEntity[]
     * @throws DatabaseException
     */
    public function handle(UserDTO $userDTO): array
    {
        return $this->userService->getUsers($userDTO->email, $userDTO->name);
    }
}
