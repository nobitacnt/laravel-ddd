<?php

namespace Modules\Order\Application\Mappers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Order\Application\DTOs\OrderDTO;
use Modules\Order\Application\DTOs\OrderItemDTO;
use Modules\Order\Application\DTOs\QueryOrderDTO;
use Modules\Order\Application\DTOs\ResponseOrderDTO;
use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Entities\OrderItemEntity;
use Modules\Order\Domain\Factories\OrderFactory;
use Modules\Shared\Domain\Exceptions\FactoryException;

class OrderMapper {

    /**
     * @param OrderDTO $orderDTO
     * @return OrderEntity
     * @throws FactoryException
     */
    public static function dtoToEntity(OrderDTO $orderDTO): OrderEntity
    {
        return OrderFactory::createOrderEntity(
            id: $orderDTO->id,
            code: $orderDTO->code,
            userId: $orderDTO->userId,
            status: null,
            amount: $orderDTO->amount,
            quantity: $orderDTO->quantity,
        );
    }

    /**
     * @param OrderItemDTO $itemDTO
     * @return OrderItemEntity
     */
    public static function orderItemDTOtoEntity(OrderItemDTO $itemDTO): OrderItemEntity
    {
        return new OrderItemEntity(
            id: $itemDTO->id,
            orderId: $itemDTO->orderId,
            skuId: $itemDTO->skuId,
            amount: $itemDTO->amount,
            quantity: $itemDTO->quantity
        );
    }

    /**
     * @param OrderItemDTO[] $itemDTOs
     * @return OrderItemEntity[]
     */
    public static function orderItemDTOsToEntities(array $itemDTOs): array
    {
        $orderItemEntities = [];
        foreach ($itemDTOs as $itemDTO) {
            $orderItemEntities[] = self::orderItemDTOtoEntity($itemDTO);
        }
        return $orderItemEntities;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return OrderDTO
     */
    public static function requestToDTO(Request $request, ?int $id = null): OrderDTO
    {
        $items = (array)$request->get('items');
        return new OrderDTO(
            id: $id,
            code: $request->string('code'),
            items: self::makeOrderItemDTOFromRequest($items, $id),
            userId: $request->integer('user_id'),
            amount: $request->get('amount'),
            quantity: $request->get('quantity'),
        );
    }

    /**
     * @param array $items
     * @param $id
     * @return OrderItemDTO[]
     */
    public static function makeOrderItemDTOFromRequest(array $items, $id): array
    {
        $itemDTOs = [];
        foreach ($items as $item) {
            $itemDTOs[] = new OrderItemDTO(
                id: (int)Arr::get($item, 'id'),
                orderId: $id,
                skuId: (int)Arr::get($item, 'sku_id'),
                amount: Arr::get($item, 'amount'),
                quantity: Arr::get($item, 'quantity'),
            );
        }

        return $itemDTOs;
    }


    /**
     * @param OrderItemEntity[] $items
     * @return OrderItemDTO[]
     */
    public static function makeOrderItemDTOFromEntities(array $items): array
    {
        $itemDTOs = [];
        foreach ($items as $item) {
            $itemDTOs[] = new OrderItemDTO(
                id: $item->id,
                orderId: $item->orderId,
                skuId: $item->skuId,
                amount: $item->amount,
                quantity: $item->quantity,
            );
        }

        return $itemDTOs;
    }


    /**
     * @param Request $request
     * @param int|null $id
     * @return QueryOrderDTO
     */
    public static function requestToQueryDTO(Request $request, ?int $id = null): QueryOrderDTO
    {
        return new QueryOrderDTO(
            id: $id,
            code: $request->string('code'),
            skuCode: $request->get('sku_code'),
        );
    }

    /**
     * @param OrderAggregate[] $orderAggregates
     * @return ResponseOrderDTO[]
     */
    public static function aggregatesToResponseOrderDTOs(array $orderAggregates): array
    {
        $list = [];
        foreach ($orderAggregates as $orderAggregate) {
            $list[] = self::aggregateToResponseOrderDTO($orderAggregate);
        }
        return $list;
    }

    /**
     * @param OrderAggregate $orderAggregate
     * @return ResponseOrderDTO
     */
    public static function aggregateToResponseOrderDTO(OrderAggregate $orderAggregate): ResponseOrderDTO
    {
        $orderEntity = $orderAggregate->getRoot();
        return new ResponseOrderDTO(
            id: $orderEntity->id,
            code: $orderEntity->code,
            status: $orderEntity->status,
            items: self::makeOrderItemDTOFromEntities($orderAggregate->getItems()),
            amount: $orderAggregate->getAmount(),
            quantity: $orderAggregate->getQuantity(),
        );
    }
}
