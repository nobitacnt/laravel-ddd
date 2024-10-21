<?php

namespace Modules\User\Domain\Services;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\Repositories\IUserRepository;
use Throwable;

readonly class UserService
{
    public function __construct(
        private IUserRepository $userRepository
    ) {}

    /**
     * @param string|null $email
     * @param string|null $name
     * @return array|UserEntity[]
     * @throws DatabaseException
     */
    public function getUsers(string $email = null, string $name = null): array
    {
        try {
            return $this->userRepository->getUsers($email, $name);
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
     * @param UserEntity $userEntity
     * @return UserEntity
     * @throws DatabaseException
     */
    public function storeUser(UserEntity $userEntity): UserEntity
    {
        try {
            return $this->userRepository->storeUser($userEntity);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to store user: ' . $e->getMessage());
        }
    }

    /**
     * @param UserEntity $userEntity
     * @return UserEntity
     * @throws DatabaseException
     */
    public function updateUser(UserEntity $userEntity): UserEntity
    {
        try {
            return $this->userRepository->updateUser($userEntity);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * @param int $userId
     * @return UserEntity
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function findUserById(int $userId): UserEntity
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
