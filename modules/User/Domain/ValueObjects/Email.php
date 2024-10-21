<?php
namespace Modules\User\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\IncorrectEmailFormatException;

final readonly class Email
{
    public function __construct(private string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new IncorrectEmailFormatException();
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
