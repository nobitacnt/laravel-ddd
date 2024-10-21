<?php
namespace Modules\Order\Application\DTOs;

class QueryOrderDTO
{
    /**
     * @param int|null $id
     * @param string|null $code
     * @param string|null $skuCode
     */
    public function __construct(
        public ?int $id,
        public ?string $code,
        public ?string $skuCode,
    )
    {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'sku_code' => $this->skuCode,
        ];
    }
}
