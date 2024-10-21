<?php
namespace Modules\Order\Application\DTOs;

class OrderItemDTO
{
    /**
     * @param int|null $id
     * @param int|string|null $orderId
     * @param int|string $skuId
     * @param float|null $amount
     * @param int|null $quantity
     */
    public function __construct(
        public ?int            $id,
        public int|string|null $orderId,
        public int|string      $skuId,
        public ?float          $amount,
        public ?int            $quantity,
    )
    {}


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
