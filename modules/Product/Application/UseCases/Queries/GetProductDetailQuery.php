<?php
namespace Modules\Product\Application\UseCases\Queries;
use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Modules\Product\Domain\Services\ProductService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
readonly class GetProductDetailQuery
{
    public function __construct(
        private ProductService $orderService
    ){}

    /**
     * @param int $orderId
     * @return ProductAggregate
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function handle(int $orderId): ProductAggregate
    {
        return $this->orderService->findProductById($orderId);
    }
}
