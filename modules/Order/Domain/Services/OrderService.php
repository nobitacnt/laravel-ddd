<?php

namespace Modules\Order\Domain\Services;
use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Modules\Order\Domain\Repositories\IOrderRepository;
use Throwable;

readonly class OrderService
{
    public function __construct(
        private IOrderRepository $orderRepository
    ) {}

    /**
     * @param array $request
     * @return OrderAggregate[]
     * @throws DatabaseException
     */
    public function getOrders(array $request = []): array
    {
        try {
            return $this->orderRepository->getOrders($request);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to fetch orders: ' . $e->getMessage());
        }
    }

    /**
     * @param string $id
     * @return bool
     */
    public function orderExists(string $id): bool
    {
        return $this->orderRepository->exists($id);
    }

    /**
     * @param string $id
     * @return void
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function deleteOrder(string $id): void
    {
        if(!$this->orderRepository->exists($id)) {
            throw new EntityNotFoundException('Order is not existed!');
        }

        try {

            $this->orderRepository->delete($id);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to store order: ' . $e->getMessage());
        }
    }

    /**
     * @param OrderAggregate $orderAggregate
     * @return OrderAggregate|null
     * @throws DatabaseException
     */
    public function storeOrder(OrderAggregate $orderAggregate): ?OrderAggregate
    {
        try {
            return $this->orderRepository->storeOrder($orderAggregate);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to store order: ' . $e->getMessage());
        }
    }

    /**
     * @param OrderAggregate $orderAggregate
     * @return OrderAggregate
     * @throws DatabaseException
     */
    public function updateOrder(OrderAggregate $orderAggregate): OrderAggregate
    {
        try {
            return $this->orderRepository->updateOrder($orderAggregate);

        } catch (Throwable $e) {
            throw new DatabaseException('Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * @param int $orderId
     * @return OrderAggregate|null
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function findOrderById(int $orderId): ?OrderAggregate
    {
        try {
            $existingOrder = $this->orderRepository->findOrderById($orderId);
        } catch(Throwable $e) {
            throw new DatabaseException('Failed to get existing order: '.$e->getMessage());
        }

        if(!$existingOrder) {
            throw new EntityNotFoundException('Order is not existed.');
        }

        return $existingOrder;
    }
}
