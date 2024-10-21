<?php
namespace Modules\Product\Domain\Entities;

use Modules\Shared\Domain\Entities\BaseEntity;

class ProductEntity extends BaseEntity
{
    /**
     * @var SkuEntity[]
     */
    protected array $skus;

    /**
     * @param int|null $id
     * @param string $code
     * @param string $status
     * @param array $images
     */
    public function __construct(
        public ?int $id,
        public string $code,
        public string $status,
        public array $images,
    ) {}

    /**
     * @param SkuEntity[] $skus
     * @return void
     */
    public function setSkus(array $skus): void
    {
        $this->skus = $skus;
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

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'code' => $this->code,
            'images' => $this->images,
        ];
    }
}
