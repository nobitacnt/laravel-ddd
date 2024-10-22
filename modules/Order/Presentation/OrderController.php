<?php
namespace Modules\Order\Presentation;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Order\Application\Mappers\OrderMapper;
use Modules\Order\Application\UseCases\Commands\StoreOrderCommand;
use Modules\Order\Application\UseCases\Commands\UpdateOrderCommand;
use Modules\Order\Application\UseCases\Queries\GetOrderDetailQuery;
use Modules\Shared\Presentation\BaseController;
use Modules\Order\Application\UseCases\Commands\DeleteOrderCommand;
use Modules\Order\Application\UseCases\Queries\GetOrdersQuery;
use Modules\Order\Presentation\Requests\StoreOrderRequest;
use Modules\Order\Presentation\Requests\UpdateOrderRequest;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OrderController extends BaseController
{
    /**
     * @param Request $request
     * @param GetOrdersQuery $getOrdersQuery
     * @return JsonResponse
     */
    public function get(Request $request, GetOrdersQuery $getOrdersQuery): JsonResponse
    {
        try {
            $queryOrderDTO = OrderMapper::requestToQueryDTO($request);
            $orders   = $getOrdersQuery->handle($queryOrderDTO);

            return $this->sendResponse(
                result: OrderMapper::aggregatesToResponseOrderDTOs($orders),
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param GetOrderDetailQuery $detailQuery
     * @return JsonResponse
     */
    public function detail(int $id, GetOrderDetailQuery $detailQuery): JsonResponse
    {
        try {
            $orderAggregate  = $detailQuery->handle($id);

            return $this->sendResponse(
                result: OrderMapper::aggregateToResponseOrderDTO($orderAggregate)->toArray(),
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param StoreOrderRequest $request
     * @param StoreOrderCommand $storeOrderCommand
     *
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request, StoreOrderCommand $storeOrderCommand): JsonResponse
    {
        try {
            $orderDTO       = OrderMapper::requestToDTO($request);
            $orderAggregate = $storeOrderCommand->handle($orderDTO);

            return $this->sendResponse(
                result: OrderMapper::aggregateToResponseOrderDTO($orderAggregate)->toArray(),
                httpCode: Response::HTTP_CREATED,
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param UpdateOrderRequest $request
     * @param UpdateOrderCommand $updateOrderCommand
     *
     * @return JsonResponse
     */
    public function update(int $id, UpdateOrderRequest $request, UpdateOrderCommand $updateOrderCommand): JsonResponse
    {
        try {
            $orderDTO    = OrderMapper::requestToDTO($request);
            $orderAggregate = $updateOrderCommand->handle($orderDTO);
            return $this->sendResponse(
                result: OrderMapper::aggregateToResponseOrderDTO($orderAggregate)->toArray(),
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param DeleteOrderCommand $deleteOrderCommand
     *
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteOrderCommand $deleteOrderCommand): JsonResponse
    {
        try {
            $deleteOrderCommand->handle($id);
            return $this->sendResponse(httpCode: Response::HTTP_NO_CONTENT);

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }
}
