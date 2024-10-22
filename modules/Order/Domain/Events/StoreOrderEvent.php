<?php

namespace Modules\Order\Domain\Events;
use Modules\Order\Domain\Aggregate\OrderAggregate;

class StoreOrderEvent
{
    public function __construct(public OrderAggregate $orderAggregate)
    {}
}
