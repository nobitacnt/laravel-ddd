<?php

namespace Modules\Order\Domain\Repositories;

use Modules\Shared\Domain\IBaseRepository;
use Modules\Order\Domain\Entities\OrderEntity;

interface IOrderRepository extends IBaseRepository
{
    /**
     * @param array $request
     * @return OrderEntity[]
     */
    public function getOrders(array $request = []): array;

    /**
     * @param int $id
     * @return OrderEntity|null
     */
    public function findOrderById(int $id): ?OrderEntity;

    /**
     * @param string $code
     * @return bool
     */
    public function codeExists(string $code): bool;

    /**
     * @param OrderEntity $orderEntity
     * @return OrderEntity|null
     */
    public function storeOrder(OrderEntity $orderEntity): ?OrderEntity;

    /**
     * @param OrderEntity $orderEntity
     */
    public function updateOrder(OrderEntity $orderEntity): OrderEntity;

    /**
     * @param string $id
     * @return void
     */
    public function deleteOrder(string $id): void;

}
