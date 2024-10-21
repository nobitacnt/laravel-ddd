<?php

namespace Modules\Order\Application\Mappers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Order\Application\DTOs\OrderDTO;
use Modules\Order\Application\DTOs\OrderItemDTO;
use Modules\Order\Application\DTOs\QueryOrderDTO;
use Modules\Order\Application\DTOs\ResponseOrderDTO;
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
        $orderItemsIdentities = [];
        foreach ($orderDTO->itemDTOs as $itemDTO) {
            $orderItemsIdentities[] = self::orderItemDTOtoEntity($itemDTO);
        }
        return OrderFactory::create(
            $orderDTO->id,
            $orderDTO->code,
            $orderDTO->userId,
            $orderItemsIdentities
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
     * @param Request $request
     * @param int|null $id
     * @return OrderDTO
     */
    public static function requestToDTO(Request $request, ?int $id = null): OrderDTO
    {
        $items = (array)$request->get('items');
        $itemDTOs = [];
        foreach ($items as $item) {
            $itemDTOs[] = new OrderItemDTO(
                id: Arr::get($item, 'id'),
                orderId: $id,
                skuId: Arr::get($item, 'sku_id'),
                amount: Arr::get($item, 'amount'),
                quantity: Arr::get($item, 'quantity'),
            );
        }
        return new OrderDTO(
            id: $id,
            code: $request->string('code'),
            itemDTOs: $itemDTOs,
            userId: $request->integer('user_id'),
            amount: $request->get('amount'),
            quantity: $request->get('quantity'),
        );
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
     * @param array $orderEntities
     * @return ResponseOrderDTO[]
     */
    public static function entitiesToResponseOrderDTOs(array $orderEntities): array
    {
        $list = [];
        foreach ($orderEntities as $orderEntity) {
            $list[] = self::entityToResponseOrderDTO($orderEntity);
        }
        return $list;
    }

    /**
     * @param OrderEntity $orderEntity
     * @return ResponseOrderDTO
     */
    public static function entityToResponseOrderDTO(OrderEntity $orderEntity): ResponseOrderDTO
    {
        return new ResponseOrderDTO(
            id: $orderEntity->id,
            code: $orderEntity->code,
            items: $orderEntity->getItems(),
            amount: $orderEntity->getAmount(),
            quantity: $orderEntity->getQuantity(),
        );
    }
}
