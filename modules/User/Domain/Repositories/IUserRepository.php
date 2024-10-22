<?php

namespace Modules\User\Domain\Repositories;

use Modules\Shared\Domain\IBaseRepository;
use Modules\User\Domain\Aggregate\UserAggregate;

interface IUserRepository extends IBaseRepository
{
    /**
     * @param array $filter
     * @return UserAggregate[]
     */
    public function getUsers(array $filter): array;

    /**
     * @param int $id
     * @return UserAggregate|null
     */
    public function findUserById(int $id): ?UserAggregate;

    /**
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool;

    /**
     * @param UserAggregate $userAggregate
     * @return UserAggregate|null
     */
    public function storeUser(UserAggregate $userAggregate): ?UserAggregate;

    /**
     * @param UserAggregate $userAggregate
     */
    public function updateUser(UserAggregate $userAggregate): UserAggregate;

    /**
     * @param string $id
     * @return void
     */
    public function deleteUser(string $id): void;

}
