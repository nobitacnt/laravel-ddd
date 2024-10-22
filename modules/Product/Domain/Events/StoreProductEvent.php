<?php

namespace Modules\Product\Domain\Events;
use Modules\Product\Domain\Aggregate\ProductAggregate;

class StoreProductEvent
{
    public function __construct(public ProductAggregate $productAggregate)
    {}
}
