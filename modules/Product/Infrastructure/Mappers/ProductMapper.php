<?php

namespace Modules\Product\Infrastructure\Mappers;
use Illuminate\Database\Eloquent\Collection;
use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Product\Domain\Entities\SkuEntity;
use Modules\Product\Infrastructure\EloquentModels\ProductModel;
use Modules\Product\Infrastructure\EloquentModels\SkuModel;
use Modules\Product\Domain\Entities\ProductEntity;

class ProductMapper {

    /**
     * @param ProductModel $model
     * @return ProductEntity
     */
    public static function modelToEntity(ProductModel $model): ProductEntity
    {
        return new ProductEntity(
            $model->id,
            $model->code,
            $model->status,
            $model->images
        );
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


    /**
     * @param ProductModel $model
     * @return ProductAggregate
     */
    public static function modelToAggregate(ProductModel $model): ProductAggregate
    {
        $skus = [];
        foreach ($model->skus as $sku) {
            $skus[] = self::modelSkuToEntity($sku);
        }
        return new ProductAggregate(
            self::modelToEntity($model),
            $skus,
        );
    }


    /**
     * @param Collection $models
     * @return ProductAggregate[]
     */
    public static function eloquentCollectionToAggregates(Collection $models): array
    {
        $productAggregates = [];
        foreach ($models as $model) {
            $productAggregates[] = self::modelToAggregate($model);
        }

        return $productAggregates;
    }
}
