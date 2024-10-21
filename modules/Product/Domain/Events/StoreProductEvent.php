<?php

namespace Modules\Product\Domain\Events;
use Modules\Product\Domain\Entities\ProductEntity;

class StoreProductEvent
{
    public function __construct(public ProductEntity $productEntity)
    {}
}
