<?php
namespace Modules\Product\Application\DTOs;

class ProductDTO
{
    /**
     * @param int|null $id
     * @param string $code
     * @param array $skuDTOs
     * @param string|null $status
     * @param array|null $images
     */
    public function __construct(
        public ?int $id,
        public string $code,
        public array $skuDTOs,
        public ?string $status,
        public ?array $images,
    )
    {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'skuDTOs' => $this->skuDTOs,
            'status' => $this->status,
            'images' => $this->images,
        ];
    }
}
