<?php
namespace Modules\Product\Presentation;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Product\Application\Mappers\ProductMapper;
use Modules\Product\Application\UseCases\Commands\StoreProductCommand;
use Modules\Product\Application\UseCases\Commands\UpdateProductCommand;
use Modules\Product\Application\UseCases\Queries\GetProductDetailQuery;
use Modules\Shared\Presentation\BaseController;
use Modules\Product\Application\UseCases\Commands\DeleteProductCommand;
use Modules\Product\Application\UseCases\Queries\GetProductsQuery;
use Modules\Product\Presentation\Requests\StoreProductRequest;
use Modules\Product\Presentation\Requests\UpdateProductRequest;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductController extends BaseController
{
    /**
     * @param Request $request
     * @param GetProductsQuery $getProductsQuery
     * @return JsonResponse
     */
    public function get(Request $request, GetProductsQuery $getProductsQuery): JsonResponse
    {
        try {
            $queryProductDTO  = ProductMapper::requestToQueryDTO($request);
            $productAggregates = $getProductsQuery->handle($queryProductDTO);

            return $this->sendResponse(
                result: ProductMapper::aggregatesToResponseProductDTOs($productAggregates),
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param GetProductDetailQuery $detailQuery
     * @return JsonResponse
     */
    public function detail(int $id, GetProductDetailQuery $detailQuery): JsonResponse
    {
        try {
            $productAggregate   = $detailQuery->handle($id);

            return $this->sendResponse(
                result: ProductMapper::aggregateToResponseProductDTO($productAggregate)->toArray(),
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param StoreProductRequest $request
     * @param StoreProductCommand $storeProductCommand
     *
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request, StoreProductCommand $storeProductCommand): JsonResponse
    {
        try {
            $productDTO       = ProductMapper::requestToDTO($request);
            $productAggregate = $storeProductCommand->handle($productDTO);

            return $this->sendResponse(
                result: ProductMapper::aggregateToResponseProductDTO($productAggregate)->toArray(),
                httpCode: Response::HTTP_CREATED,
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param UpdateProductRequest $request
     * @param UpdateProductCommand $updateProductCommand
     *
     * @return JsonResponse
     */
    public function update(int $id, UpdateProductRequest $request, UpdateProductCommand $updateProductCommand): JsonResponse
    {
        try {
            $productDTO       = ProductMapper::requestToDTO($request, $id);
            $productAggregate = $updateProductCommand->handle($productDTO);
            return $this->sendResponse(
                ProductMapper::aggregateToResponseProductDTO($productAggregate)->toArray()
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param DeleteProductCommand $deleteProductCommand
     *
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteProductCommand $deleteProductCommand): JsonResponse
    {
        try {
            $deleteProductCommand->handle($id);
            return $this->sendResponse(httpCode: Response::HTTP_NO_CONTENT);

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }
}
