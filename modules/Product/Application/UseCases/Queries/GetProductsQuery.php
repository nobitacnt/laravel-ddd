<?php
namespace Modules\Product\Application\UseCases\Queries;
use Modules\Product\Application\DTOs\QueryProductDTO;
use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Product\Domain\Services\ProductService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
readonly class GetProductsQuery
{
    public function __construct(
        private ProductService $productService
    ){}

    /**
     * @param QueryProductDTO $queryProductDTO
     * @return ProductAggregate[]
     * @throws DatabaseException
     */
    public function handle(QueryProductDTO $queryProductDTO): array
    {
        return $this->productService->getProducts($queryProductDTO->toArray());
    }
}
