<?php

namespace Modules\Product\Infrastructure\Repositories;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Product\Domain\Enums\ProductStatus;
use Modules\Product\Infrastructure\EloquentModels\SkuModel;
use Modules\Product\Infrastructure\Mappers\ProductMapper;
use Modules\Shared\Infrastructure\BaseRepository;
use Modules\Product\Domain\Entities\ProductEntity;
use Modules\Product\Domain\Repositories\IProductRepository;
use Modules\Product\Infrastructure\EloquentModels\ProductModel;
use Modules\Shared\Infrastructure\Mappers\CollectionMapper;

class ProductRepository extends BaseRepository implements IProductRepository
{

    public function getModel(): string
    {
        return ProductModel::class;
    }

    /**
     * @param array $request
     * @return ProductEntity[]
     */
    public function getProducts(array $request = []): array
    {
        if(!empty($request['coe'])) {
            $this->query->where('code', $request['coe']);
        }

        $products = $this->query->get();
        return CollectionMapper::toEntities($products);
    }

    /**
     * @param int $id
     * @return ProductEntity|null
     */
    public function findProductById(int $id): ?ProductEntity
    {
        $product = $this->find($id);
        return ($product instanceof ProductModel) ? $product->toEntity() : null;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function codeExists(string $code): bool
    {
        return $this->existsByCond(['code' => $code]);
    }

    /**
     * @param ProductEntity $productEntity
     * @return ProductEntity|null
     */
    public function storeProduct(ProductEntity $productEntity): ?ProductEntity
    {
        $product = DB::transaction(function() use ($productEntity) {
            /** @var ProductModel $product */
            $productInput = $productEntity->toArray();
            $productInput['status']   = ProductStatus::NEW->value;
            $product      = $this->model->create($productInput);
            $product->skus()->createMany(
                ProductMapper::skuEntitiesToArray($productEntity->getSkus())
            );
            return $product;
        });

        return ($product instanceof ProductModel) ? $product->toEntity() : null;
    }

    /**
     * @param ProductEntity $productEntity
     * @return ProductEntity
     */
    public function updateProduct(ProductEntity $productEntity): ProductEntity
    {
        $this->update($productEntity->id, $productEntity->toArray());

        return $productEntity;
    }

    public function deleteProduct(string $id): void
    {
        $this->model->find($id)->delete();
    }
}
