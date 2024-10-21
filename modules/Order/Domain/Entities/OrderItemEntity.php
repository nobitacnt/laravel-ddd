<?php
namespace Modules\Order\Domain\Entities;

use Modules\Shared\Domain\Entities\BaseEntity;

class OrderItemEntity extends BaseEntity
{
    /**
     * @param int|null $id
     * @param int|string|null $orderId
     * @param int|string|null $skuId
     * @param float|null $amount
     * @param int|null $quantity
     */
    public function __construct(
        public ?int $id,
        public int|string|null $orderId,
        public int|string|null $skuId,
        public ?float $amount,
        public ?int $quantity,
    ) {}

    public function changeAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function changeQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->orderId,
            'sku_id' => $this->skuId,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
        ];
    }
}
