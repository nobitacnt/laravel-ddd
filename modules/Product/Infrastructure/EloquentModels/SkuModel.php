<?php

namespace Modules\Product\Infrastructure\EloquentModels;
use Modules\Product\Domain\Entities\SkuEntity;
use Modules\Product\Infrastructure\Mappers\ProductMapper;
use Modules\Shared\Infrastructure\EloquentModels\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Product
 * @package Modules\Product\Infrastructure\EloquentModels\SkuModel
 *
 * @property int $id
 * @property int $product_id
 * @property string $code
 * @property float $price
 * @property string $image
 *
 * @property ProductModel $product
 *
 * */
class SkuModel extends Model
{
    protected $table = 'skus';

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    /**
     * @return SkuEntity
     */
    public function toEntity(): SkuEntity
    {
        return ProductMapper::modelSkuToEntity($this);
    }
}
