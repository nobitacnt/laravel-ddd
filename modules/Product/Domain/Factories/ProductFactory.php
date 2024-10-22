<?php
namespace Modules\Product\Domain\Factories;

use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Product\Domain\Entities\SkuEntity;
use Modules\Shared\Domain\Exceptions\FactoryException;
use Modules\Product\Domain\Entities\ProductEntity;
use Throwable;

class ProductFactory
{
    /**
     * @param int|null $id
     * @param string $code
     * @param string $status
     * @param array|null $images
     * @return ProductEntity
     * @throws FactoryException
     */
    public static function createProductEntity(
        ?int $id,
        string $code,
        string $status,
        ?array $images,
    ): ProductEntity
    {
        try {
            return new ProductEntity(
                id: $id,
                code: $code,
                status: $status,
                images: $images
            );

        } catch(Throwable $e) {
            throw new FactoryException('Error creating Product identity: ' . $e->getMessage());
        }
    }

    /**
     * @param int|null $id
     * @param int|null $productId
     * @param string|null $code
     * @param string|null $image
     * @param float|null $price
     * @return SkuEntity
     * @throws FactoryException
     */
    public static function createSkuEntity(
        ?int $id,
        int|null $productId,
        string|null $code,
        string|null $image,
        ?float $price,
    ): SkuEntity
    {
        try {
            return new SkuEntity(
                id: $id,
                productId: $productId,
                code: $code,
                image: $image,
                price: $price,
            );

        } catch(Throwable $e) {
            throw new FactoryException('Error creating Sku identity: ' . $e->getMessage());
        }
    }

    /**
     * @param ProductEntity $productEntity
     * @param SkuEntity[] $skus
     * @return ProductAggregate
     * @throws FactoryException
     */
    public static function createProductAggregate(
        ProductEntity $productEntity,
        array $skus,
    ): ProductAggregate
    {
        try {
            return new ProductAggregate(
                $productEntity,
                $skus
            );

        } catch(Throwable $e) {
            throw new FactoryException('Error creating Product Aggregate: ' . $e->getMessage());
        }
    }
}
