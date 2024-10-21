<?php

namespace Modules\Product\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Collection;
use Modules\Product\Infrastructure\Mappers\ProductMapper;
use Modules\Shared\Infrastructure\EloquentModels\Model;
use Modules\Product\Domain\Entities\ProductEntity;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class Product
 * @package Modules\Product\Infrastructure\EloquentModels\ProductModel
 *
 * @property int $id
 * @property string $code
 * @property string $status
 * @property array $images
 *
 * @property Collection|SkuModel[] $skus
 *
 * */

class ProductModel extends Model
{
    protected $table = 'products';

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'images',
        'code',
    ];

    protected $casts = [
        'images' => 'array'
    ];

    /**
     * @return HasMany
     */
    public function skus(): HasMany
    {
        return $this->hasMany(SkuModel::class, 'product_id', 'id');
    }

    /**
     * @return ProductEntity
     */
    public function toEntity(): ProductEntity
    {
        return ProductMapper::modelToEntity($this);
    }
}
