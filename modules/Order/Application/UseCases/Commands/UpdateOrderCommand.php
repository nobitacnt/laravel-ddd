<?php
namespace Modules\Order\Application\UseCases\Commands;

use Modules\Order\Application\DTOs\OrderDTO;
use Modules\Order\Application\Mappers\OrderMapper;
use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Factories\OrderFactory;
use Modules\Order\Domain\Services\OrderService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\FactoryException;

readonly class UpdateOrderCommand
{
    public function __construct(
        private OrderService $orderService
    )
    {}

    /**
     * @param OrderDTO $orderDTO
     * @return OrderAggregate
     * @throws DatabaseException|FactoryException
     */
    public function handle(OrderDTO $orderDTO): OrderAggregate
    {
        $orderEntity    = OrderMapper::dtoToEntity($orderDTO);
        $itemEntities   = OrderMapper::orderItemDTOsToEntities($orderDTO->items);
        $orderAggregate = OrderFactory::createOrderAggregate($orderEntity, $itemEntities);

        return $this->orderService->updateOrder($orderAggregate);
    }
}
