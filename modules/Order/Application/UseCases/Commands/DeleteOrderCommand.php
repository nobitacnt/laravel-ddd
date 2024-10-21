<?php
namespace Modules\Order\Application\UseCases\Commands;

use Modules\Order\Domain\Services\OrderService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;

readonly class DeleteOrderCommand
{
    public function __construct(
        private OrderService $orderService
    )
    {}

    /**
     * @param string $id
     * @return void
     * @throws DatabaseException
     * @throws EntityNotFoundException
     */
    public function handle(string $id): void
    {
        $this->orderService->deleteOrder($id);
    }
}
