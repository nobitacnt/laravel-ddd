<?php

namespace Modules\Order\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Events\StoreOrderEvent;

class StoreOrderListener
{
    public function handle(StoreOrderEvent $event): void
    {
        $orderEntity = $event->orderEntity;
        $this->logStoreOrder($orderEntity);
    }

    public function logStoreOrder(OrderEntity $orderEntity): void
    {
        Log::info('storeOrder '.$orderEntity->code);
    }
}
