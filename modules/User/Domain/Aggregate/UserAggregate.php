<?php
namespace Modules\User\Domain\Aggregate;

use Modules\User\Domain\Entities\UserEntity;
use Modules\Shared\Domain\Aggregate\AggregateRoot;

class UserAggregate extends AggregateRoot
{
    /**
     * @param UserEntity $orderEntity
     */
    public function __construct(
        private readonly UserEntity $orderEntity,
    ) {}

    /**
     * @return UserEntity
     */
    public function getRoot(): UserEntity
    {
        return $this->orderEntity;
    }
}
