<?php
namespace Modules\Product\Application\DTOs;

class QueryProductDTO
{
    /**
     * @param int|null $id
     * @param string|null $code
     */
    public function __construct(
        public ?int $id,
        public ?string $code,
    )
    {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
        ];
    }
}
