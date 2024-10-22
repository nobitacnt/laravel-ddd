<?php
namespace Modules\Shared\Domain\Aggregate;

use Modules\Shared\Domain\Entities\BaseEntity;

abstract class AggregateRoot
{
    /**
     * @return BaseEntity
     */
    public abstract function getRoot(): BaseEntity;
}
