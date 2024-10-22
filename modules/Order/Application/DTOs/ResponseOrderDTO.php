<?php
namespace Modules\Order\Application\DTOs;

class ResponseOrderDTO
{
    /**
     * @param int|null $id
     * @param string $code
     * @param string|null $status
     * @param OrderItemDTO[] $items
     * @param float|null $amount
     * @param int|null $quantity
     */
    public function __construct(
        public ?int $id,
        public string $code,
        public ?string $status,
        public array $items,
        public ?float $amount,
        public ?int $quantity,
    )
    {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'status' => $this->status,
            'items' => $this->items,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
        ];
    }
}
