<?php
namespace Modules\Order\Presentation\Requests;
use Modules\Order\Domain\Rules\CodeUniqueRule;
use Modules\Shared\Presentation\Requests\BaseRequest;

class BaseOrderRequest extends BaseRequest
{
    public function rules(CodeUniqueRule $orderUniqueRule): array
    {
        return [
            "code" => [
                "bail",
                "required",
                "string",
                "max:100",
                $orderUniqueRule,
            ],
            "user_id" => ["bail", "required", "integer", "exists:Modules\User\Infrastructure\EloquentModels\UserModel,id"],
            "items" => ["bail", "required", "array"],
            "items.*.sku_id" => ["bail", "required", "integer", "exists:Modules\Product\Infrastructure\EloquentModels\SkuModel,id"],
            "items.*.quantity" => ["bail", "required", "integer"],
            "items.*.amount" => ["bail", "required", " numeric"],
        ];
    }
}
