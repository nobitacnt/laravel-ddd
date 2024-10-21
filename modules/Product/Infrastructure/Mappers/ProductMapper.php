<?php

namespace Modules\Product\Infrastructure\Mappers;
use Modules\Product\Domain\Entities\SkuEntity;
use Modules\Product\Infrastructure\EloquentModels\SkuModel;
use Modules\Product\Infrastructure\EloquentModels\ProductModel;
use Modules\Product\Domain\Entities\ProductEntity;

class ProductMapper {

    /**
     * @param ProductModel $model
     * @return ProductEntity
     */
    public static function modelToEntity(ProductModel $model): ProductEntity
    {
        $productEntity = new ProductEntity(
            $model->id,
            $model->code,
            $model->status,
            $model->images
        );
        $skuEntities = [];
        foreach ($model->skus as $sku) {
            $skuEntities[] = self::modelSkuToEntity($sku);
        }

        $productEntity->setSkus($skuEntities);

        return $productEntity;
    }

    /**
     * @param SkuModel $model
     * @return SkuEntity
     */
    public static function modelSkuToEntity(SkuModel $model): SkuEntity
    {
        return new SkuEntity(
            $model->id,
            $model->product_id,
            $model->code,
            $model->image,
            $model->price
        );
    }

    /**
     * @param SkuEntity[] $skuEntities
     * @return array
     */
    public static function skuEntitiesToArray(array $skuEntities = []): array
    {
        $array = [];
        foreach ($skuEntities as $skuEntity) {
            $array[] = $skuEntity->toArray();
        }

        return $array;
    }
}
