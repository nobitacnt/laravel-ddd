<?php

namespace Modules\Order\Infrastructure\EloquentModels;
use Modules\Order\Domain\Entities\OrderItemEntity;
use Modules\Order\Infrastructure\Mappers\OrderMapper;
use Modules\Shared\Infrastructure\EloquentModels\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Order
 * @package Modules\Order\Infrastructure\EloquentModels\OrderItemModel
 *
 * @property int $id
 * @property int $order_id
 * @property int $sku_id
 * @property int $quantity
 * @property float $amount
 *
 * @property OrderModel $order
 *
 * */
class OrderItemModel extends Model
{
    protected $table = 'order_items';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'id');
    }

    /**
     * @return OrderItemEntity
     */
    public function toEntity(): OrderItemEntity
    {
        return OrderMapper::modelItemToEntity($this);
    }
}
