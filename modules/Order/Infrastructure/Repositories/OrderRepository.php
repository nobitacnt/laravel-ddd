<?php

namespace Modules\Order\Infrastructure\Repositories;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Order\Domain\Enums\OrderStatus;
use Modules\Order\Infrastructure\EloquentModels\OrderItemModel;
use Modules\Order\Infrastructure\Mappers\OrderMapper;
use Modules\Shared\Infrastructure\BaseRepository;
use Modules\Order\Domain\Entities\OrderEntity;
use Modules\Order\Domain\Repositories\IOrderRepository;
use Modules\Order\Infrastructure\EloquentModels\OrderModel;
use Modules\Shared\Infrastructure\Mappers\CollectionMapper;

class OrderRepository extends BaseRepository implements IOrderRepository
{

    public function getModel(): string
    {
        return OrderModel::class;
    }

    /**
     * @param array $request
     * @return OrderEntity[]
     */
    public function getOrders(array $request = []): array
    {
        if(!empty($request['coe'])) {
            $this->query->where('code', $request['coe']);
        }

        $orders = $this->query->get();
        return CollectionMapper::toEntities($orders);
    }

    /**
     * @param int $id
     * @return OrderEntity|null
     */
    public function findOrderById(int $id): ?OrderEntity
    {
        $order = $this->find($id);
        return ($order instanceof OrderModel) ? $order->toEntity() : null;
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
     * @param OrderEntity $orderEntity
     * @return OrderEntity|null
     */
    public function storeOrder(OrderEntity $orderEntity): ?OrderEntity
    {
        $order = DB::transaction(function() use ($orderEntity) {
            /** @var OrderModel $order */
            $orderInput = $orderEntity->toArray();
            $orderInput['status']   = OrderStatus::NEW->value;
            $order      = $this->model->create($orderInput);
            $order->orderItems()->createMany(
                OrderMapper::orderItemEntitiesToArray($orderEntity->getItems())
            );
            return $order;
        });

        return ($order instanceof OrderModel) ? $order->toEntity() : null;
    }

    /**
     * @param OrderEntity $orderEntity
     * @return OrderEntity
     */
    public function updateOrder(OrderEntity $orderEntity): OrderEntity
    {
        $this->update($orderEntity->id, $orderEntity->toArray());

        return $orderEntity;
    }

    public function deleteOrder(string $id): void
    {
        $this->model->find($id)->delete();
    }
}
