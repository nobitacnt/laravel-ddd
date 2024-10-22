<?php
namespace Modules\Product\Domain\Aggregate;

use Modules\Product\Domain\Entities\ProductEntity;
use Modules\Product\Domain\Entities\SkuEntity;
use Modules\Shared\Domain\Aggregate\AggregateRoot;

class ProductAggregate extends AggregateRoot
{
    /**
     * @param ProductEntity $orderEntity
     * @param SkuEntity[] $skus
     */
    public function __construct(
        private readonly ProductEntity $orderEntity,
        private array                $skus,
    ) {}

    /**
     * @return ProductEntity
     */
    public function getRoot(): ProductEntity
    {
        return $this->orderEntity;
    }

    /**
     * @return SkuEntity[]
     */
    public function getSkus(): array
    {
        return $this->skus;
    }

    /**
     * @param SkuEntity $skuEntity
     * @return void
     */
    public function addSku(SkuEntity $skuEntity): void
    {
        $this->skus[] = $skuEntity;
    }

    /**
     * @param SkuEntity $skuEntity
     * @return void
     */
    public function removeSku(SkuEntity $skuEntity): void
    {
        foreach ($this->skus as $key => $sku) {
            if($sku->id == $skuEntity->id) {
                unset($this->skus[$key]);
            }
        }
    }

    /**
     * @param SkuEntity $skuEntity
     * @return void
     */
    public function updateSku(SkuEntity $skuEntity): void
    {
        foreach ($this->skus as $key => $sku) {
            if($sku->id == $skuEntity->id) {
                $this->skus[$key] = $skuEntity;
            }
        }
    }
}
