<?php

namespace Modules\Product\Infrastructure\Repositories;
use Illuminate\Support\Facades\DB;
use Modules\Product\Domain\Aggregate\ProductAggregate;
use Modules\Product\Domain\Enums\ProductStatus;
use Modules\Product\Infrastructure\Mappers\ProductMapper;
use Modules\Shared\Infrastructure\BaseRepository;
use Modules\Product\Domain\Repositories\IProductRepository;
use Modules\Product\Infrastructure\EloquentModels\ProductModel;

class ProductRepository extends BaseRepository implements IProductRepository
{

    public function getModel(): string
    {
        return ProductModel::class;
    }

    /**
     * @param array $request
     * @return ProductAggregate[]
     */
    public function getProducts(array $request = []): array
    {
        if(!empty($request['coe'])) {
            $this->query->where('code', $request['coe']);
        }

        $products = $this->query->get();
        return ProductMapper::eloquentCollectionToAggregates($products);
    }

    /**
     * @param int $id
     * @return ProductAggregate|null
     */
    public function findProductById(int $id): ?ProductAggregate
    {
        $product = $this->find($id);
        return ($product instanceof ProductModel) ? ProductMapper::modelToAggregate($product) : null;
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
     * @param ProductAggregate $productAggregate
     * @return ProductAggregate|null
     */
    public function storeProduct(ProductAggregate $productAggregate): ?ProductAggregate
    {
        $product = DB::transaction(function() use ($productAggregate) {
            /** @var ProductModel $product */
            $productInput = $productAggregate->getRoot()->toArray();
            $productInput['status']   = ProductStatus::NEW->value;
            $product      = $this->model->create($productInput);
            $product->skus()->createMany(
                ProductMapper::skuEntitiesToArray($productAggregate->getSkus())
            );
            return $product;
        });

        return ($product instanceof ProductModel) ? ProductMapper::modelToAggregate($product) : null;
    }

    /**
     * @param ProductAggregate $productAggregate
     * @return ProductAggregate
     */
    public function updateProduct(ProductAggregate $productAggregate): ProductAggregate
    {
        $this->update($productAggregate->getRoot()->id, $productAggregate->getRoot()->toArray());

        return $productAggregate;
    }

    public function deleteProduct(string $id): void
    {
        $this->model->find($id)->delete();
    }
}
