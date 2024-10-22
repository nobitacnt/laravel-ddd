<?php

namespace Modules\User\Infrastructure\Mappers;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Domain\Aggregate\UserAggregate;
use Modules\User\Domain\Factories\UserFactory;
use Modules\User\Infrastructure\EloquentModels\UserModel;
use Modules\User\Domain\Entities\UserEntity;
use Modules\Shared\Domain\Exceptions\FactoryException;

class UserMapper {

    /**
     * @param UserModel $model
     * @return UserEntity
     * @throws FactoryException
     */
    public static function modelToEntity(UserModel $model): UserEntity
    {
        return UserFactory::createUserEntity(
            $model->id,
            $model->name,
            $model->email,
            $model->password,
        );
    }

    /**
     * @param UserModel $model
     * @return UserAggregate
     * @throws FactoryException
     */
    public static function modelToAggregate(UserModel $model): UserAggregate
    {
        return UserFactory::createUserAggregate(
            self::modelToEntity($model)
        );
    }


    /**
     * @param Collection $models
     * @return UserAggregate[]
     * @throws FactoryException
     */
    public static function eloquentCollectionToAggregates(Collection $models): array
    {
        $userAggregates = [];
        foreach ($models as $model) {
            $userAggregates[] = self::modelToAggregate($model);
        }

        return $userAggregates;
    }
}
