<?php

namespace Modules\Order\Infrastructure\Repositories;
use Illuminate\Support\Facades\DB;
use Modules\Order\Domain\Aggregate\OrderAggregate;
use Modules\Order\Domain\Enums\OrderStatus;
use Modules\Order\Infrastructure\Mappers\OrderMapper;
use Modules\Shared\Infrastructure\BaseRepository;
use Modules\Order\Domain\Repositories\IOrderRepository;
use Modules\Order\Infrastructure\EloquentModels\OrderModel;

class OrderRepository extends BaseRepository implements IOrderRepository
{

    public function getModel(): string
    {
        return OrderModel::class;
    }

    /**
     * @param array $request
     * @return OrderAggregate[]
     */
    public function getOrders(array $request = []): array
    {
        if(!empty($request['coe'])) {
            $this->query->where('code', $request['coe']);
        }

        $orders = $this->query->get();
        return OrderMapper::eloquentCollectionToAggregates($orders);
    }

    /**
     * @param int $id
     * @return OrderAggregate|null
     */
    public function findOrderById(int $id): ?OrderAggregate
    {
        $order = $this->find($id);
        return ($order instanceof OrderModel) ? OrderMapper::modelToAggregate($order) : null;
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
     * @param OrderAggregate $orderAggregate
     * @return OrderAggregate|null
     */
    public function storeOrder(OrderAggregate $orderAggregate): ?OrderAggregate
    {
        $order = DB::transaction(function() use ($orderAggregate) {
            /** @var OrderModel $order */
            $orderInput = $orderAggregate->getRoot()->toArray();
            $orderInput['status']   = OrderStatus::NEW->value;
            $orderInput['amount']   = $orderAggregate->getAmount();
            $orderInput['quantity'] = $orderAggregate->getQuantity();
            $order      = $this->model->create($orderInput);
            $order->orderItems()->createMany(
                OrderMapper::orderItemEntitiesToArray($orderAggregate->getItems())
            );
            return $order;
        });

        return ($order instanceof OrderModel) ? OrderMapper::modelToAggregate($order) : null;
    }

    /**
     * @param OrderAggregate $orderAggregate
     * @return OrderAggregate
     */
    public function updateOrder(OrderAggregate $orderAggregate): OrderAggregate
    {
        $root = $orderAggregate->getRoot();
        $this->update($root->id, $root->toArray());

        return $orderAggregate;
    }
}
