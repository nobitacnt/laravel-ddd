<?php

namespace Modules\Order\Infrastructure\Mappers;
use Modules\Order\Domain\Entities\OrderItemEntity;
use Modules\Order\Infrastructure\EloquentModels\OrderItemModel;
use Modules\Order\Infrastructure\EloquentModels\OrderModel;
use Modules\Order\Domain\Entities\OrderEntity;

class OrderMapper {

    /**
     * @param OrderModel $model
     * @return OrderEntity
     */
    public static function modelToEntity(OrderModel $model): OrderEntity
    {
        $orderEntity = new OrderEntity(
            $model->id,
            $model->code,
            $model->user_id,
        );
        $orderItemEntities = [];
        foreach ($model->orderItems as $item) {
            $orderItemEntities[] = self::modelItemToEntity($item);
        }

        $orderEntity->setItems($orderItemEntities);
        $orderEntity->setAmount($model->amount);
        $orderEntity->setQuantity($model->quantity);

        return $orderEntity;
    }

    /**
     * @param OrderItemModel $model
     * @return OrderItemEntity
     */
    public static function modelItemToEntity(OrderItemModel $model): OrderItemEntity
    {
        return new OrderItemEntity(
            $model->id,
            $model->order_id,
            $model->sku_id,
            $model->amount,
            $model->quantity,
        );
    }

    /**
     * @param OrderItemEntity[] $orderItemEntities
     * @return array
     */
    public static function orderItemEntitiesToArray(array $orderItemEntities = []): array
    {
        $array = [];
        foreach ($orderItemEntities as $itemEntity) {
            $array[] = $itemEntity->toArray();
        }

        return $array;
    }
}
