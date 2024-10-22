<?php
namespace Modules\Product\Domain\Entities;

use Modules\Shared\Domain\Entities\BaseEntity;

class ProductEntity extends BaseEntity
{
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
