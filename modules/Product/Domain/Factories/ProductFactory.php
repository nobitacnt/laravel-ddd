<?php
namespace Modules\Product\Domain\Factories;

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
     * @param array $skus
     * @return ProductEntity
     * @throws FactoryException
     */
    public static function create(
        ?int $id,
        string $code,
        string $status,
        ?array $images,
        array $skus,
    ): ProductEntity
    {
        try {
            $productEntity = new ProductEntity(
                id: $id,
                code: $code,
                status: $status,
                images: $images
            );
            foreach ($skus as $sku) {
                $productEntity->addSku($sku);
            }
            return $productEntity;

        } catch(Throwable $e) {
            throw new FactoryException('Error creating Product identity: ' . $e->getMessage());
        }
    }
}
