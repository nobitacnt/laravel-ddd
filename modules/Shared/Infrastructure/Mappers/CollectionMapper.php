<?php

namespace Modules\Shared\Infrastructure\Mappers;
use Illuminate\Database\Eloquent\Collection;
use Modules\Shared\Domain\Entities\BaseEntity;
use Modules\Shared\Infrastructure\EloquentModels\Model;

class CollectionMapper {

    /**
     * @param Collection $collections
     * @return BaseEntity[]
     */
    public static function toEntities(Collection $collections): array
    {
        $entities = [];
        /** @var Model $model */
        foreach ($collections as $model) {
            $entities[] = $model->toEntity();
        }
        return $entities;
    }
}
