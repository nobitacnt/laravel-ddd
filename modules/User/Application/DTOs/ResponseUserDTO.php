<?php
namespace Modules\User\Application\DTOs;
class ResponseUserDTO
{
    /**
     * @param string|null $id
     * @param string $name
     * @param string $email
     */
    public function __construct(
        public ?string $id,
        public string $name,
        public string $email,
    )
    {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
