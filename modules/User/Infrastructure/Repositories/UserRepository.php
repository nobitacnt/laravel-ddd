<?php

namespace Modules\User\Infrastructure\Repositories;
use Illuminate\Support\Arr;
use Modules\Shared\Domain\Exceptions\FactoryException;
use Modules\Shared\Infrastructure\BaseRepository;
use Modules\User\Domain\Aggregate\UserAggregate;
use Modules\User\Domain\Repositories\IUserRepository;
use Modules\User\Infrastructure\EloquentModels\UserModel;
use Modules\User\Infrastructure\Mappers\UserMapper;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function getModel(): string
    {
        return UserModel::class;
    }

    /**
     * @param array $filter
     * @return array|UserAggregate[]
     * @throws FactoryException
     */
    public function getUsers(array $filter): array
    {
        if($email = Arr::get($filter, 'email')) {
            $this->query->where('email', $email);
        }

        if($name = Arr::get($filter, 'name')) {
            $this->query->where('name', 'LIKE', "%$name%");
        }

        $users = $this->query->get();
        return UserMapper::eloquentCollectionToAggregates($users);
    }

    /**
     * @param int $id
     * @return UserAggregate|null
     * @throws FactoryException
     */
    public function findUserById(int $id): ?UserAggregate
    {
        $user = $this->find($id);
        return ($user instanceof UserModel) ? UserMapper::modelToAggregate($user) : null;
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
     * @param UserAggregate $userAggregate
     * @return UserAggregate|null
     * @throws FactoryException
     */
    public function storeUser(UserAggregate $userAggregate): ?UserAggregate
    {
        $input = $userAggregate->getRoot()->toArray();
        $user  = $this->model->create($input);
        return ($user instanceof UserModel) ? UserMapper::modelToAggregate($user) : null;
    }

    /**
     * @param UserAggregate $userAggregate
     * @return UserAggregate
     */
    public function updateUser(UserAggregate $userAggregate): UserAggregate
    {
        $root = $userAggregate->getRoot();
        $this->update($root->id, [
            'name' => $root->name,
            'email' => $root->email,
        ]);

        return $userAggregate;
    }

    public function deleteUser(string $id): void
    {
        $this->model->find($id)->delete();
    }
}
