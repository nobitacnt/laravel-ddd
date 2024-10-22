<?php

namespace Modules\Order\Infrastructure\Mappers;
use Illuminate\Database\Eloquent\Collection;
use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Order\Domain\Entities\OrderItemEntity;
use Modules\Order\Domain\Factories\OrderFactory;
use Modules\Order\Infrastructure\EloquentModels\OrderItemModel;
use Modules\Order\Infrastructure\EloquentModels\OrderModel;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Shared\Domain\Exceptions\FactoryException;

class OrderMapper {

    /**
     * OrderEntity
     * @param OrderModel $model
     * @return OrderEntity
     * @throws FactoryException
     */
    public static function modelToEntity(OrderModel $model): OrderEntity
    {
        return OrderFactory::createOrderEntity(
            $model->id,
            $model->code,
            $model->user_id,
            $model->status,
            $model->amount,
            $model->quantity
        );
    }


    /**
     * @param OrderItemModel $model
     * @return OrderItemEntity
     * @throws FactoryException
     */
    public static function modelItemToEntity(OrderItemModel $model): OrderItemEntity
    {
        return OrderFactory::createOrderItemEntity(
            $model->id,
            $model->order_id,
            $model->sku_id,
            $model->amount,
            $model->quantity,
        );
    }

    /**
     * @param OrderModel $model
     * @return OrderAggregate
     * @throws FactoryException
     */
    public static function modelToAggregate(OrderModel $model): OrderAggregate
    {
        $orderItems = [];
        foreach ($model->orderItems as $orderItem) {
            $orderItems[] = self::modelItemToEntity($orderItem);
        }
        return new OrderAggregate(
            self::modelToEntity($model),
            $orderItems,
        );
    }


    /**
     * @param Collection $models
     * @return OrderAggregate[]
     */
    public static function eloquentCollectionToAggregates(Collection $models): array
    {
        $orderAggregates = [];
        foreach ($models as $model) {
            $orderAggregates[] = self::modelToAggregate($model);
        }

        return $orderAggregates;
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
