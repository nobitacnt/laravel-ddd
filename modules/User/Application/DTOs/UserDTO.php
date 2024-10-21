<?php
namespace Modules\User\Application\DTOs;
class UserDTO
{
    /**
     * @param string|null $id
     * @param string $name
     * @param string $email
     * @param string|null $password
     */
    public function __construct(
        public ?string $id,
        public string $name,
        public string $email,
        public ?string $password,
    )
    {}

    /**
     * @param string|null $id
     * @param string $name
     * @param string $email
     * @param string|null $password
     * @return self
     */
    public static function create(
        ?string $id,
        string $name,
        string $email,
        ?string $password
    ): self
    {
        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
