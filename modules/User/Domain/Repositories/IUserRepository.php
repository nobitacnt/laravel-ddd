<?php

namespace Modules\User\Domain\Repositories;

use Modules\Shared\Domain\IBaseRepository;
use Modules\User\Domain\Entities\UserEntity;

interface IUserRepository extends IBaseRepository
{
    /**
     * @param string|null $email
     * @param string|null $name
     * @return UserEntity[]
     */
    public function getUsers(?string $email, ?string $name): array;

    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function findUserById(int $id): ?UserEntity;

    /**
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool;

    /**
     * @param UserEntity $userEntity
     * @return UserEntity|null
     */
    public function storeUser(UserEntity $userEntity): ?UserEntity;

    /**
     * @param UserEntity $userEntity
     */
    public function updateUser(UserEntity $userEntity): UserEntity;

    /**
     * @param string $id
     * @return void
     */
    public function deleteUser(string $id): void;

}
