<?php

namespace Modules\Order\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Order\Domain\Events\StoreOrderEvent;

class StoreOrderListener
{
    public function handle(StoreOrderEvent $event): void
    {
        $orderAggregate = $event->orderAggregate;
        $this->logStoreOrder($orderAggregate);
    }

    public function logStoreOrder(OrderAggregate $orderAggregate): void
    {
        Log::info('storeOrder '.$orderAggregate->getRoot()->code);
    }
}
