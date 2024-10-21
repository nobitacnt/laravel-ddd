<?php
namespace Modules\User\Application\UseCases\Commands;

use Modules\User\Application\DTOs\UserDTO;
use Modules\User\Application\Mappers\UserMapper;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\Services\UserService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\FactoryException;

readonly class UpdateUserCommand
{
    public function __construct(
        private UserService $userService
    )
    {}

    /**
     * @param UserDTO $userDTO
     * @return UserEntity
     * @throws DatabaseException|FactoryException
     */
    public function handle(UserDTO $userDTO): UserEntity
    {
        $userEntity = UserMapper::dtoToEntity($userDTO);
        $this->userService->updateUser($userEntity);
    }
}
