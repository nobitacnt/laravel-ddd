<?php

namespace Modules\Product\Domain\Services;
use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Modules\Product\Domain\Repositories\IProductRepository;
use Throwable;

readonly class ProductService
{
    public function __construct(
        private IProductRepository $productRepository
    ) {}

    /**
     * @param array $request
     * @return ProductAggregate[]
     * @throws DatabaseException
     */
    public function getProducts(array $request = []): array
    {
        try {
            return $this->productRepository->getProducts($request);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to fetch products: ' . $e->getMessage());
        }
    }

    /**
     * @param string $id
     * @return bool
     */
    public function productExists(string $id): bool
    {
        return $this->productRepository->exists($id);
    }

    /**
     * @param string $id
     * @return void
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function deleteProduct(string $id): void
    {
        if(!$this->productRepository->exists($id)) {
            throw new EntityNotFoundException('Product is not existed!');
        }

        try {

            $this->productRepository->deleteProduct($id);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to store product: ' . $e->getMessage());
        }
    }

    /**
     * @param ProductAggregate $productAggregate
     * @return ProductAggregate
     * @throws DatabaseException
     */
    public function storeProduct(ProductAggregate $productAggregate): ProductAggregate
    {
        try {
            return $this->productRepository->storeProduct($productAggregate);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to store product: ' . $e->getMessage());
        }
    }

    /**
     * @param ProductAggregate $productAggregate
     * @return ProductAggregate
     * @throws DatabaseException
     */
    public function updateProduct(ProductAggregate $productAggregate): ProductAggregate
    {
        try {
            return $this->productRepository->updateProduct($productAggregate);

        } catch (Throwable $e) {
            throw new DatabaseException('Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * @param int $productId
     * @return ProductAggregate
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function findProductById(int $productId): ProductAggregate
    {
        try {
            $existingProduct = $this->productRepository->findProductById($productId);
        } catch(Throwable $e) {
            throw new DatabaseException('Failed to get existing product: '.$e->getMessage());
        }

        if(!$existingProduct) {
            throw new EntityNotFoundException('Product is not existed.');
        }

        return $existingProduct;
    }
}
