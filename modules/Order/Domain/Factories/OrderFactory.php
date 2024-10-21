<?php
namespace Modules\Order\Domain\Factories;

use Modules\Order\Domain\Entities\OrderItemEntity;
use Modules\Shared\Domain\Exceptions\FactoryException;
use Modules\Order\Domain\Entities\OrderEntity;
use Throwable;

class OrderFactory
{
    /**
     * @param int|null $id
     * @param string $code
     * @param OrderItemEntity[] $items
     * @param int $userId
     * @return OrderEntity
     * @throws FactoryException
     */
    public static function create(
        ?int $id,
        string $code,
        int $userId,
        array $items,
    ): OrderEntity
    {
        try {
            $orderEntity = new OrderEntity(
                id: $id,
                code: $code,
                userId: $userId,
            );
            foreach ($items as $item) {
                $orderEntity->addItem($item);
            }
            return $orderEntity;

        } catch(Throwable $e) {
            throw new FactoryException('Error creating Order identity: ' . $e->getMessage());
        }
    }
}
