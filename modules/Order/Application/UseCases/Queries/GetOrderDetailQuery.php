<?php
namespace Modules\Order\Application\UseCases\Queries;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Services\OrderService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
readonly class GetOrderDetailQuery
{
    public function __construct(
        private OrderService $orderService
    ){}

    /**
     * @param int $orderId
     * @return OrderEntity
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function handle(int $orderId): OrderEntity
    {
        return $this->orderService->findOrderById($orderId);
    }
}
