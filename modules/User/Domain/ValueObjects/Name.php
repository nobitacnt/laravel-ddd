<?php
namespace Modules\User\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\ValueRequiredException;

final class Name
{
    private string $name;

    public function __construct(?string $name)
    {
        if (!$name) {
            throw new ValueRequiredException('name');
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
