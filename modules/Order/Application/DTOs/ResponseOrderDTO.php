<?php
namespace Modules\Order\Application\DTOs;
use Modules\Order\Domain\Entities\OrderItemEntity;

class ResponseOrderDTO
{
    /**
     * @param int|null $id
     * @param string $code
     * @param OrderItemEntity[] $items
     * @param float|null $amount
     * @param int|null $quantity
     */
    public function __construct(
        public ?int $id,
        public string $code,
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
            'items' => $this->items,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
        ];
    }
}
