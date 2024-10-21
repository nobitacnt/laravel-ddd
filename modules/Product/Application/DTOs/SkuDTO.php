<?php
namespace Modules\Product\Application\DTOs;

class SkuDTO
{
    /**
     * @param int|null $id
     * @param int|string|null $productId
     * @param int|string $code
     * @param float|null $price
     * @param string|null $image
     */
    public function __construct(
        public ?int            $id,
        public int|string|null $productId,
        public int|string      $code,
        public ?float          $price,
        public ?string         $image,
    )
    {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->productId,
            'code' => $this->code,
            'price' => $this->price,
            'image' => $this->image,
        ];
    }
}
