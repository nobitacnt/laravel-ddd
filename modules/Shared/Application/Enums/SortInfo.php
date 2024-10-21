<?php
namespace Modules\Shared\Application\Enums;

enum SortInfo: string
{
    case DEFAULT_SORT = 'created_at';
    case DEFAULT_SORT_DIRECTION = 'asc';
}
