<?php
namespace Modules\Order\Domain\Aggregate;

use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Entities\OrderItemEntity;
use Modules\Shared\Domain\Aggregate\AggregateRoot;

class OrderAggregate extends AggregateRoot
{
    /**
     * @param OrderEntity $orderEntity
     * @param OrderItemEntity[] $items
     */
    public function __construct(
        private readonly OrderEntity $orderEntity,
        private array                $items,
    ) {}

    /**
     * @return OrderEntity
     */
    public function getRoot(): OrderEntity
    {
        return $this->orderEntity;
    }

    /**
     * @return OrderItemEntity[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        $amount = 0;
        foreach ($this->items as $itemEntity) {
            $amount += $itemEntity->amount;
        }
        return $amount;
    }

    /**
     * @return integer
     */
    public function getQuantity(): int
    {
        $quantity = 0;
        foreach ($this->items as $itemEntity) {
            $quantity += $itemEntity->quantity;
        }
        return $quantity;
    }

    /**
     * @param OrderItemEntity $itemEntity
     * @return void
     */
    public function addItem(OrderItemEntity $itemEntity): void
    {
        $this->items[] = $itemEntity;
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
            }
        }
    }
}
