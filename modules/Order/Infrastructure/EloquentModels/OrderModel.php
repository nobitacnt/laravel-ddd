<?php

namespace Modules\Order\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Infrastructure\Mappers\OrderMapper;
use Modules\Shared\Infrastructure\EloquentModels\Model;
use Modules\Order\Domain\Entities\OrderEntity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\User\Infrastructure\EloquentModels\UserModel;


/**
 * Class Order
 * @package Modules\Order\Infrastructure\EloquentModels\OrderModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property string $status
 * @property int $quantity
 * @property float $amount
 *
 * @property Collection|OrderItemModel[] $orderItems
 * @property UserModel|null $user
 *
 * */

class OrderModel extends Model
{
    protected $table = 'orders';

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'user_id',
        'code',
        'amount',
        'quantity'
    ];

    /**
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItemModel::class, 'order_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    /**
     * @return OrderEntity
     */
    public function toEntity(): OrderEntity
    {
        return OrderMapper::modelToEntity($this);
    }
}
