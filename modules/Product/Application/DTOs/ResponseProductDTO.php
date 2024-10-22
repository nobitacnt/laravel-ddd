<?php
namespace Modules\Product\Application\DTOs;

class ResponseProductDTO
{
    /**
     * @param int|null $id
     * @param string $code
     * @param SkuDTO[] $skus
     * @param string|null $status
     * @param array|null $images
     */
    public function __construct(
        public ?int $id,
        public string $code,
        public array $skus,
        public ?string $status,
        public ?array $images,
    )
    {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'skus' => $this->skus,
            'status' => $this->status,
            'images' => $this->images,
        ];
    }
}
