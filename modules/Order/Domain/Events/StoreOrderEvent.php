<?php

namespace Modules\Order\Domain\Events;
use Modules\Order\Domain\Entities\OrderEntity;

class StoreOrderEvent
{
    public function __construct(public OrderEntity $orderEntity)
    {}
}
