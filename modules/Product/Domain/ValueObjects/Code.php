<?php
namespace Modules\Product\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\ValueRequiredException;

final class Code
{
    private string $code;

    public function __construct(?string $code)
    {
        if (!$code) {
            throw new ValueRequiredException('code');
        }

        $this->code = $code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
