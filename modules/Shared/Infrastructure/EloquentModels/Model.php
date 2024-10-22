<?php

namespace Modules\Shared\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Modules\Shared\Domain\Entities\BaseEntity;

/**
 * Class Model
 * @package App\Base
 *
 * @method static create(array $input) create record with eloquent
 * @method static updateOrCreate(array $input, array $update) create record with eloquent
 * @method static whereIn($value, array $items)
 * @method static find($id)
 */
abstract class Model extends BaseModel
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
