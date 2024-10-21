<?php
namespace Modules\Product\Domain\Entities;

use Modules\Shared\Domain\Entities\BaseEntity;

class SkuEntity extends BaseEntity
{
    public function __construct(
        public ?int $id,
        public int|string|null $productId,
        public string|null $code,
        public string|null $image,
        public ?float $price,
    ) {}

    public function changePrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return array
     */
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
