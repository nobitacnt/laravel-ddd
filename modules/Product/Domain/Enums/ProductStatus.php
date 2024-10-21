<?php
namespace Modules\Product\Domain\Enums;

enum ProductStatus: string
{
    case NEW = 'new';
    case PUBLISHED = 'published';
}
