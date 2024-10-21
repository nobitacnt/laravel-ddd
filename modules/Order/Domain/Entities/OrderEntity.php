<?php
namespace Modules\Order\Domain\Entities;

use Modules\Shared\Domain\Entities\BaseEntity;

class OrderEntity extends BaseEntity
{
    protected ?float $amount = null;
    protected ?float $quantity = null;

    /**
     * @var OrderItemEntity[]
     */
    protected array $items;

    /**
     * @param int|null $id
     * @param string $code
     * @param int $userId
     */
    public function __construct(
        public ?int $id,
        public string $code,
        public int $userId,
    ) {}

    /**
     * @param OrderItemEntity[] $items
     * @return void
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return OrderItemEntity[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int|float $amount
     * @return void
     */
    public function setAmount(int|float $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param int $quantity
     * @return void
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }


    /**
     * @param OrderItemEntity $itemEntity
     * @return void
     */
    public function addItem(OrderItemEntity $itemEntity): void
    {
        $this->items[] = $itemEntity;
        $this->amount   += $itemEntity->amount;
        $this->quantity += $itemEntity->quantity;
    }

    /**
     * @param OrderItemEntity $itemEntity
     * @return void
     */
    public function removeItem(OrderItemEntity $itemEntity): void
    {
        foreach ($this->items as $key => $item) {
            if($item->id == $itemEntity->id) {
                unset($this->items[$key]);
                $this->amount   -= $itemEntity->amount;
                $this->quantity -= $itemEntity->quantity;
            }
        }
    }

    /**
     * @param OrderItemEntity $itemEntity
     * @return void
     */
    public function updateItem(OrderItemEntity $itemEntity): void
    {
        foreach ($this->items as $key => $item) {
            if($item->id == $itemEntity->id) {
                $this->items[$key] = $itemEntity;

                $this->amount   += ($itemEntity->amount - $item->amount);
                $this->quantity += ($itemEntity->quantity - $item->quantity);
            }
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'code' => $this->code,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
            'items' => $this->items,
        ];
    }
}
