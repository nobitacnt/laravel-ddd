<?php
namespace Modules\Shared\Domain\ValueObjects;

final class Pagination
{
    public function __construct(
        public int $currentPage,
        public int $lastPage,
        public int $perPage,
        public int $total,
        public int|float|null $from,
        public int|float|null $to,
    )
    {}

    public function toArray(string $format = 'Y-m-d H:i:s'): array
    {
        return  [
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'from' => $this->from,
            'to' => $this->to
        ];
    }
}
