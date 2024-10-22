<?php

namespace Modules\Product\Application\Mappers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Product\Application\DTOs\ProductDTO;
use Modules\Product\Application\DTOs\SkuDTO;
use Modules\Product\Application\DTOs\QueryProductDTO;
use Modules\Product\Application\DTOs\ResponseProductDTO;
use Modules\Product\Domain\Aggregate\ProductAggregate;
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
        return ProductFactory::createProductEntity(
            $productDTO->id,
            $productDTO->code,
            $productDTO->status,
            $productDTO->images,
        );
    }


    /**
     * @param SkuDTO $itemDTO
     * @return SkuEntity
     * @throws FactoryException
     */
    public static function skuDTOtoEntity(SkuDTO $itemDTO): SkuEntity
    {
        return  ProductFactory::createSkuEntity (
            id: $itemDTO->id,
            productId: $itemDTO->productId,
            code: $itemDTO->code,
            image: $itemDTO->image,
            price: $itemDTO->price,
        );
    }

    /**
     * @param SkuDTO[] $itemDTOs
     * @return SkuEntity[]
     * @throws FactoryException
     */
    public static function skuDTOsToEntities(array $itemDTOs): array
    {
        $skuEntities = [];
        foreach ($itemDTOs as $itemDTO) {
            $skuEntities[] = self::skuDTOtoEntity($itemDTO);
        }
        return $skuEntities;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return ProductDTO
     */
    public static function requestToDTO(Request $request, ?int $id = null): ProductDTO
    {
        $skus = (array)$request->get('skus');

        return new ProductDTO(
            id: $id,
            code: $request->string('code'),
            skus: self::makeSkuDTOFromRequest($skus, $id),
            status: $request->string('status'),
            images: $request->get('images')
        );
    }

    /**
     * @param array $skus
     * @param $id
     * @return array
     */
    public static function makeSkuDTOFromRequest(array $skus, $id): array
    {
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

        return $skuDTOs;
    }

    /**
     * @param SkuEntity[] $skus
     * @return array
     */
    public static function makeSkuDTOFromEntities(array $skus): array
    {
        $skuDTOs = [];
        foreach ($skus as $sku) {
            $skuDTOs[] = new SkuDTO(
                id: $sku->id,
                productId: $sku->productId,
                code: $sku->code,
                price: $sku->price,
                image: $sku->image
            );
        }

        return $skuDTOs;
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
     * @param ProductAggregate[] $productAggregates
     * @return ResponseProductDTO[]
     */
    public static function aggregatesToResponseProductDTOs(array $productAggregates): array
    {
        $list = [];
        foreach ($productAggregates as $productAggregate) {
            $list[] = self::aggregateToResponseProductDTO($productAggregate);
        }
        return $list;
    }

    /**
     * @param ProductAggregate $productAggregate
     * @return ResponseProductDTO
     */
    public static function aggregateToResponseProductDTO(ProductAggregate $productAggregate): ResponseProductDTO
    {
        $root = $productAggregate->getRoot();
        return new ResponseProductDTO(
            id: $root->id,
            code: $root->code,
            skus: self::makeSkuDTOFromEntities($productAggregate->getSkus()),
            status: $root->status,
            images: $root->images
        );
    }
}
