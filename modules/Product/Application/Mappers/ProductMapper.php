<?php

namespace Modules\Product\Application\Mappers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Product\Application\DTOs\ProductDTO;
use Modules\Product\Application\DTOs\SkuDTO;
use Modules\Product\Application\DTOs\QueryProductDTO;
use Modules\Product\Application\DTOs\ResponseProductDTO;
use Modules\Product\Domain\Entities\ProductEntity;
use Modules\Product\Domain\Entities\SkuEntity;
use Modules\Product\Domain\Factories\ProductFactory;
use Modules\Shared\Domain\Exceptions\FactoryException;

class ProductMapper {

    /**
     * @param ProductDTO $productDTO
     * @return ProductEntity
     * @throws FactoryException
     */
    public static function dtoToEntity(ProductDTO $productDTO): ProductEntity
    {
        $skusIdentities = [];
        foreach ($productDTO->skuDTOs as $skuDTO) {
            $skusIdentities[] = self::skuDTOtoEntity($skuDTO);
        }
        return ProductFactory::create(
            $productDTO->id,
            $productDTO->code,
            $productDTO->status,
            $productDTO->images,
            $skusIdentities
        );
    }

    /**
     * @param SkuDTO $skuDTO
     * @return SkuEntity
     */
    public static function skuDTOtoEntity(SkuDTO $skuDTO): SkuEntity
    {
        return new SkuEntity(
            id: $skuDTO->id,
            productId: $skuDTO->productId,
            code: $skuDTO->code,
            image: $skuDTO->image,
            price: $skuDTO->price,
        );
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return ProductDTO
     */
    public static function requestToDTO(Request $request, ?int $id = null): ProductDTO
    {
        $skus = (array)$request->get('skus');
        $skuDTOs = [];
        foreach ($skus as $sku) {
            $skuDTOs[] = new SkuDTO(
                id: Arr::get($sku, 'id'),
                productId: $id,
                code: Arr::get($sku, 'code'),
                price: Arr::get($sku, 'price'),
                image: Arr::get($sku, 'image')
            );
        }
        return new ProductDTO(
            id: $id,
            code: $request->string('code'),
            skuDTOs: $skuDTOs,
            status: $request->string('status'),
            images: $request->get('images')
        );
    }


    /**
     * @param Request $request
     * @param int|null $id
     * @return QueryProductDTO
     */
    public static function requestToQueryDTO(Request $request, ?int $id = null): QueryProductDTO
    {
        return new QueryProductDTO(
            id: $id,
            code: $request->string('code'),
        );
    }

    /**
     * @param array $productEntities
     * @return ResponseProductDTO[]
     */
    public static function entitiesToResponseProductDTOs(array $productEntities): array
    {
        $list = [];
        foreach ($productEntities as $productEntity) {
            $list[] = self::entityToResponseProductDTO($productEntity);
        }
        return $list;
    }

    /**
     * @param ProductEntity $productEntity
     * @return ResponseProductDTO
     */
    public static function entityToResponseProductDTO(ProductEntity $productEntity): ResponseProductDTO
    {
        return new ResponseProductDTO(
            id: $productEntity->id,
            code: $productEntity->code,
            skuDTOs: $productEntity->getSkus(),
            status: $productEntity->status,
            images: $productEntity->images
        );
    }
}
