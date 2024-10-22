<?php
namespace Modules\Order\Domain\Entities;

use Modules\Shared\Domain\Entities\BaseEntity;

class OrderEntity extends BaseEntity
{
    /**
     * @param int|null $id
     * @param string $code
     * @param int $userId
     * @param string|null $status
     * @param float|null $amount
     * @param int|null $quantity
     */
    public function __construct(
        public ?int $id,
        public string $code,
        public int $userId,
        public ?string $status,
        public ?float $amount,
        public ?int $quantity,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'code' => $this->code,
            'status' => $this->status,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
        ];
    }
}
