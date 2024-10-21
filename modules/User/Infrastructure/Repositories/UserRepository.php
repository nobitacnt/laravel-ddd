<?php

namespace Modules\User\Infrastructure\Repositories;
use Modules\Shared\Infrastructure\BaseRepository;
use Modules\Shared\Infrastructure\Mappers\CollectionMapper;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\Repositories\IUserRepository;
use Modules\User\Infrastructure\EloquentModels\UserModel;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function getModel(): string
    {
        return UserModel::class;
    }

    /**
     * @param string|null $email
     * @param string|null $name
     * @return UserEntity[]
     */
    public function getUsers(?string $email, ?string $name): array
    {
        if($email) {
            $this->query->where('email', $email);
        }

        if($name) {
            $this->query->where('name', 'LIKE', "%$name%");
        }

        $users = $this->query->get();
        return CollectionMapper::toEntities($users);
    }

    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function findUserById(int $id): ?UserEntity
    {
        $user = $this->find($id);
        return ($user instanceof UserModel) ? $user->toEntity() : null;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        return $this->existsByCond(['email' => $email]);
    }

    /**
     * @param UserEntity $userEntity
     * @return UserEntity|null
     */
    public function storeUser(UserEntity $userEntity): ?UserEntity
    {
        $user = $this->model->create($userEntity->toArray());
        return ($user instanceof UserModel) ? $user->toEntity() : null;
    }

    /**
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function updateUser(UserEntity $userEntity): UserEntity
    {
        $this->update($userEntity->id, $userEntity->toArray());

        return $userEntity;
    }

    public function deleteUser(string $id): void
    {
        $this->model->find($id)->delete();
    }
}
