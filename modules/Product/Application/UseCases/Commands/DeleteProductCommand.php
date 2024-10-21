<?php
namespace Modules\Product\Application\UseCases\Commands;

use Modules\Product\Domain\Services\ProductService;
use Modules\Shared\Domain\Exceptions\DatabaseException;
use Modules\Shared\Domain\Exceptions\EntityNotFoundException;

readonly class DeleteProductCommand
{
    public function __construct(
        private ProductService $productService
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
        $this->productService->deleteProduct($id);
    }
}
