<?php

namespace Modules\Product\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Product\Domain\Events\StoreProductEvent;

class StoreProductListener
{
    public function handle(StoreProductEvent $event): void
    {
        $productAggregate = $event->productAggregate;
        $this->logStoreProduct($productAggregate);
    }

    public function logStoreProduct(ProductAggregate $productAggregate): void
    {
        Log::info('storeProduct '.$productAggregate->getRoot()->code);
    }
}
