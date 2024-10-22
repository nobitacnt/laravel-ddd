<?php

namespace Modules\User\Application\Mappers;

use Illuminate\Http\Request;
use Modules\User\Application\DTOs\ResponseUserDTO;
use Modules\User\Application\DTOs\UserDTO;
use Modules\User\Domain\Aggregate\UserAggregate;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\Factories\UserFactory;
use Modules\Shared\Domain\Exceptions\FactoryException;

class UserMapper {

    /**
     * @param UserDTO $userDTO
     * @return UserEntity
     * @throws FactoryException
     */
    public static function dtoToEntity(UserDTO $userDTO): UserEntity
    {
        return UserFactory::createUserEntity(
            $userDTO->id,
            $userDTO->name,
            $userDTO->email,
            $userDTO->password
        );
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return UserDTO
     */
    public static function requestToDTO(Request $request, ?int $id = null): UserDTO
    {
        return new UserDTO(
            id: $id,
            name: $request->string('name'),
            email: $request->string('email'),
            password: $request->string('password'),
        );
    }

    /**
     * @param array $userEntities
     * @return ResponseUserDTO[]
     */
    public static function aggregatesToResponseUserDTOs(array $userEntities): array
    {
        $list = [];
        foreach ($userEntities as $userEntity) {
            $list[] = self::aggregateToResponseUserDTO($userEntity);
        }
        return $list;
    }

    /**
     * @param UserAggregate $userAggregate
     * @return ResponseUserDTO
     */
    public static function aggregateToResponseUserDTO(UserAggregate $userAggregate): ResponseUserDTO
    {
        $root = $userAggregate->getRoot();
        return new ResponseUserDTO(
            id: $root->id,
            name: $root->name,
            email: $root->email,
        );
    }
}
