<?php
namespace Modules\User\Domain\Factories;

use Modules\Shared\Domain\Exceptions\FactoryException;
use Modules\User\Domain\Entities\UserEntity;
use Modules\User\Domain\ValueObjects\Email;
use Modules\User\Domain\ValueObjects\Name;
use Modules\User\Domain\ValueObjects\Password;
use Throwable;

class UserFactory
{
    /**
     * @param int|null $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @return UserEntity
     * @throws FactoryException
     */
    public static function create(?int $id, string $name, string $email, string $password): UserEntity
    {
        try {
            return new UserEntity(
                id: $id,
                name: new Name($name),
                email: new Email($email),
                password: new Password($password),
            );

        } catch(Throwable $e) {
            throw new FactoryException('Error creating User identity: ' . $e->getMessage());
        }
    }
}
