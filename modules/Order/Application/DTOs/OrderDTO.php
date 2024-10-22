<?php
namespace Modules\Order\Application\DTOs;

class OrderDTO
{
    /**
     * @param int|null $id
     * @param string $code
     * @param OrderItemDTO[] $itemDTOs
     * @param int $userId
     * @param float|null $amount
     * @param int|null $quantity
     */
    public function __construct(
        public ?int $id,
        public string $code,
        public array $items,
        public int $userId,
        public ?float $amount,
        public ?int $quantity,
    )
    {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'code' => $this->code,
            'items' => $this->items,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
        ];
    }
}
