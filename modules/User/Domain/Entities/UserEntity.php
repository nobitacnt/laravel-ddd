<?php
namespace Modules\User\Domain\Entities;

use Modules\User\Domain\ValueObjects\Email;
use Modules\User\Domain\ValueObjects\Name;
use Modules\Shared\Domain\Entities\BaseEntity;
use Modules\User\Domain\ValueObjects\Password;

class UserEntity extends BaseEntity
{
    public function __construct(
        public ?int $id,
        public Name $name,
        public Email $email,
        public ?Password $password = null
    ) {}

    public function changePassword(Password $newPassword): void
    {
        $this->password = $newPassword;
    }

    public function changeEmail(Email $newEmail): void
    {
        $this->email = $newEmail;
    }

    public function changeName(Name $newName): void
    {
        $this->name = $newName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => (string)$this->getName(),
            'email' => (string)$this->getEmail(),
            'password' => (string)$this->getPassword(),
        ];
    }
}
