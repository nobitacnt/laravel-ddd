<?php

namespace Modules\Product\Domain\Repositories;

use Modules\Shared\Domain\IBaseRepository;
use Modules\Product\Domain\Entities\ProductEntity;

interface IProductRepository extends IBaseRepository
{
    /**
     * @param array $request
     * @return ProductEntity[]
     */
    public function getProducts(array $request = []): array;

    /**
     * @param int $id
     * @return ProductEntity|null
     */
    public function findProductById(int $id): ?ProductEntity;

    /**
     * @param string $code
     * @return bool
     */
    public function codeExists(string $code): bool;

    /**
     * @param ProductEntity $productEntity
     * @return ProductEntity|null
     */
    public function storeProduct(ProductEntity $productEntity): ?ProductEntity;

    /**
     * @param ProductEntity $productEntity
     */
    public function updateProduct(ProductEntity $productEntity): ProductEntity;

    /**
     * @param string $id
     * @return void
     */
    public function deleteProduct(string $id): void;

}
