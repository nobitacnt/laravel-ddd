<?php
namespace Modules\Shared\Application\DTOs;

use Illuminate\Http\Request;
use Modules\Shared\Application\Enums\PaginationInfo;
use Modules\Shared\Application\Enums\SortInfo;

class PageMetaDTO
{
    public function __construct(
        public int $page,
        public int $pageSize,
        public string $sort,
        public string $sortDirection
    ) {}

    public static function fromRequest(Request $request): self
    {
        $page = max(PaginationInfo::DEFAULT_PAGE->value, (int) $request->get('page'));
        $pageSize = max(PaginationInfo::DEFAULT_PAGE_SIZE->value, (int) $request->get('page_size'));

        $sort = $request->sort ?? SortInfo::DEFAULT_SORT->value;
        $sortDirection = $request->get('sort');

        if(!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = SortInfo::DEFAULT_SORT_DIRECTION->value;
        }

        return new self(
            $page,
            $pageSize,
            $sort,
            $sortDirection
        );
    }
}
