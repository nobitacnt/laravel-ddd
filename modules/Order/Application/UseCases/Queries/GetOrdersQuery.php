<?php
namespace Modules\Order\Application\UseCases\Queries;
use Modules\Order\Application\DTOs\QueryOrderDTO;
use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Services\OrderService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
readonly class GetOrdersQuery
{
    public function __construct(
        private OrderService $orderService
    ){}

    /**
     * @param QueryOrderDTO $queryOrderDTO
     * @return OrderAggregate[]
     * @throws DatabaseException
     */
    public function handle(QueryOrderDTO $queryOrderDTO): array
    {
        return $this->orderService->getOrders($queryOrderDTO->toArray());
    }
}
