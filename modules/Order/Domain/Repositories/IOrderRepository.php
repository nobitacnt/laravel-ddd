<?php

namespace Modules\Order\Domain\Repositories;

use Modules\Shared\Domain\IBaseRepository;
use Modules\Order\Domain\Aggregate\OrderAggregate;

interface IOrderRepository extends IBaseRepository
{
    /**
     * @param array $request
     * @return OrderAggregate[]
     */
    public function getOrders(array $request = []): array;

    /**
     * @param int $id
     * @return OrderAggregate|null
     */
    public function findOrderById(int $id): ?OrderAggregate;

    /**
     * @param string $code
     * @return bool
     */
    public function codeExists(string $code): bool;

    /**
     * @param OrderAggregate $orderAggregate
     * @return OrderAggregate|null
     */
    public function storeOrder(OrderAggregate $orderAggregate): ?OrderAggregate;

    /**
     * @param OrderAggregate $orderAggregate
     */
    public function updateOrder(OrderAggregate $orderAggregate): OrderAggregate;
}
