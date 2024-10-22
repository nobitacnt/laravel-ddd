<?php
namespace Modules\Order\Domain\Factories;

use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Order\Domain\Entities\OrderItemEntity;
use Modules\Shared\Domain\Exceptions\FactoryException;
use Modules\Order\Domain\Entities\OrderEntity;
use Throwable;

class OrderFactory
{
    /**
     * @param int|null $id
     * @param string $code
     * @param int $userId
     * @param string|null $status
     * @param float|null $amount
     * @param int|null $quantity
     * @return OrderEntity
     * @throws FactoryException
     */
    public static function createOrderEntity(
        ?int $id,
        string $code,
        int $userId,
        ?string $status,
        ?float $amount,
        ?int $quantity,
    ): OrderEntity
    {
        try {
            return new OrderEntity(
                id: $id,
                code: $code,
                userId: $userId,
                status: $status,
                amount: $amount,
                quantity: $quantity
            );

        } catch(Throwable $e) {
            throw new FactoryException('Error creating Order identity: ' . $e->getMessage());
        }
    }

    /**
     * @param int|null $id
     * @param int|string|null $orderId
     * @param int|string|null $skuId
     * @param float|null $amount
     * @param int|null $quantity
     * @return OrderItemEntity
     * @throws FactoryException
     */
    public static function createOrderItemEntity(
        ?int $id,
        int|string|null $orderId,
        int|string|null $skuId,
        ?float $amount,
        ?int $quantity,
    ): OrderItemEntity
    {
        try {
            return new OrderItemEntity(
                id: $id,
                orderId: $orderId,
                skuId: $skuId,
                amount: $amount,
                quantity: $quantity
            );

        } catch(Throwable $e) {
            throw new FactoryException('Error creating OrderItem identity: ' . $e->getMessage());
        }
    }

    /**
     * @param OrderEntity $orderEntity
     * @param array $itemEntities
     * @return OrderAggregate
     * @throws FactoryException
     */
    public static function createOrderAggregate(
        OrderEntity $orderEntity,
        array $itemEntities
    ): OrderAggregate
    {
        try {
            return new OrderAggregate($orderEntity, $itemEntities);
        } catch(Throwable $e) {
            throw new FactoryException('Error creating Order Aggregate: ' . $e->getMessage());
        }
    }
}
