<?php
namespace Modules\Shared\Domain\Entities;

abstract class BaseEntity
{
    /**
     * @return array
     */
    abstract public function toArray(): array;
}
