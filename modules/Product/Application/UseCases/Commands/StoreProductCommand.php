<?php

namespace Modules\Product\Application\UseCases\Commands;

use Modules\Product\Application\DTOs\ProductDTO;
use Modules\Product\Application\Mappers\ProductMapper;
use Modules\Product\Domain\Entities\ProductEntity;
use Modules\Product\Domain\Events\StoreProductEvent;
use Modules\Product\Domain\Services\ProductService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\FactoryException;
readonly class StoreProductCommand
{
    public function __construct(
        private ProductService $productService,
    ){}

    /**
     * @param ProductDTO $productDTO
     * @return ProductEntity
     * @throws DatabaseException|FactoryException
     */
    public function handle(ProductDTO $productDTO): ProductEntity
    {
        $productEntity = ProductMapper::dtoToEntity($productDTO);
        $productEntity = $this->productService->storeProduct($productEntity);

        event(new StoreProductEvent($productEntity));

        return $productEntity;
    }
}
