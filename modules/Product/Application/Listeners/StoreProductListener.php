<?php

namespace Modules\Product\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Product\Domain\Entities\ProductEntity;
use Modules\Product\Domain\Events\StoreProductEvent;

class StoreProductListener
{
    public function handle(StoreProductEvent $event): void
    {
        $productEntity = $event->productEntity;
        $this->logStoreProduct($productEntity);
    }

    public function logStoreProduct(ProductEntity $productEntity): void
    {
        Log::info('storeProduct '.$productEntity->code);
    }
}
