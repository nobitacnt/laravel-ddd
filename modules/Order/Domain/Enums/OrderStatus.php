<?php
namespace Modules\Order\Domain\Enums;

enum OrderStatus: string
{
    case NEW = 'new';
    case COMPLETED = 'completed';
}
