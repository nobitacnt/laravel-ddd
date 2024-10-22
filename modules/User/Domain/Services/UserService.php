<?php

namespace Modules\User\Domain\Services;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Modules\User\Domain\Aggregate\UserAggregate;
use Modules\User\Domain\Repositories\IUserRepository;
use Throwable;

readonly class UserService
{
    public function __construct(
        private IUserRepository $userRepository
    ) {}

    /**
     * @param array $filter
     * @return array|UserAggregate[]
     * @throws DatabaseException
     */
    public function getUsers(array $filter): array
    {
        try {
            return $this->userRepository->getUsers($filter);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to fetch users: ' . $e->getMessage());
        }
    }

    /**
     * @param string $id
     * @return bool
     */
    public function userExists(string $id): bool
    {
        return $this->userRepository->exists($id);
    }

    /**
     * @param string $id
     * @return void
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function deleteUser(string $id): void
    {
        if(!$this->userRepository->exists($id)) {
            throw new EntityNotFoundException('User is not existed!');
        }

        try {

            $this->userRepository->deleteUser($id);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to store user: ' . $e->getMessage());
        }
    }

    /**
     * @param UserAggregate $userAggregate
     * @return UserAggregate
     * @throws DatabaseException
     */
    public function storeUser(UserAggregate $userAggregate): UserAggregate
    {
        try {
            return $this->userRepository->storeUser($userAggregate);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to store user: ' . $e->getMessage());
        }
    }

    /**
     * @param UserAggregate $userAggregate
     * @return UserAggregate
     * @throws DatabaseException
     */
    public function updateUser(UserAggregate $userAggregate): UserAggregate
    {
        try {
            return $this->userRepository->updateUser($userAggregate);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * @param int $userId
     * @return UserAggregate
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function findUserById(int $userId): UserAggregate
    {
        try {
            $existingUser = $this->userRepository->findUserById($userId);
        } catch(Throwable $e) {
            throw new DatabaseException('Failed to get existing user: '.$e->getMessage());
        }

        if(!$existingUser) {
            throw new EntityNotFoundException('User is not existed.');
        }

        return $existingUser;
    }
}
