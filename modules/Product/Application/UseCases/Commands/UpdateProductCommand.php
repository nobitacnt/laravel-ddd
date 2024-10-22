<?php
namespace Modules\Product\Application\UseCases\Commands;

use Modules\Product\Application\DTOs\ProductDTO;
use Modules\Product\Application\Mappers\ProductMapper;
use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Product\Domain\Factories\ProductFactory;
use Modules\Product\Domain\Services\ProductService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\FactoryException;

readonly class UpdateProductCommand
{
    public function __construct(
        private ProductService $productService
    )
    {}

    /**
     * @param ProductDTO $productDTO
     * @return ProductAggregate
     * @throws DatabaseException|FactoryException
     */
    public function handle(ProductDTO $productDTO): ProductAggregate
    {
        $productEntity = ProductMapper::dtoToEntity($productDTO);
        $skusEntities  = ProductMapper::skuDTOsToEntities($productDTO->skus);
        $productAggregate = ProductFactory::createProductAggregate($productEntity, $skusEntities);
        return $this->productService->updateProduct($productAggregate);
    }
}
