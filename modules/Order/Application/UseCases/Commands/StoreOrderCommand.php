<?php

namespace Modules\Order\Application\UseCases\Commands;

use Modules\Order\Application\DTOs\OrderDTO;
use Modules\Order\Application\Mappers\OrderMapper;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Events\StoreOrderEvent;
use Modules\Order\Domain\Services\OrderService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\FactoryException;
readonly class StoreOrderCommand
{
    public function __construct(
        private OrderService $orderService,
    ){}

    /**
     * @param OrderDTO $orderDTO
     * @return OrderEntity
     * @throws DatabaseException|FactoryException
     */
    public function handle(OrderDTO $orderDTO): OrderEntity
    {
        $orderEntity = OrderMapper::dtoToEntity($orderDTO);
        $orderEntity = $this->orderService->storeOrder($orderEntity);

        event(new StoreOrderEvent($orderEntity));

        return $orderEntity;
    }
}
