<?php

namespace Modules\Product\Domain\Repositories;

use Modules\Shared\Domain\IBaseRepository;
use Modules\Product\Domain\Aggregate\ProductAggregate;

interface IProductRepository extends IBaseRepository
{
    /**
     * @param array $request
     * @return ProductAggregate[]
     */
    public function getProducts(array $request = []): array;

    /**
     * @param int $id
     * @return ProductAggregate|null
     */
    public function findProductById(int $id): ?ProductAggregate;

    /**
     * @param string $code
     * @return bool
     */
    public function codeExists(string $code): bool;

    /**
     * @param ProductAggregate $productAggregate
     * @return ProductAggregate|null
     */
    public function storeProduct(ProductAggregate $productAggregate): ?ProductAggregate;

    /**
     * @param ProductAggregate $productAggregate
     */
    public function updateProduct(ProductAggregate $productAggregate): ProductAggregate;

    /**
     * @param string $id
     * @return void
     */
    public function deleteProduct(string $id): void;

}
