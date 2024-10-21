<?php
namespace Modules\Product\Presentation\Requests;
use Modules\Product\Domain\Rules\CodeUniqueRule;
use Modules\Shared\Presentation\Requests\BaseRequest;

class BaseProductRequest extends BaseRequest
{
    public function rules(CodeUniqueRule $productUniqueRule): array
    {
        return [
            "code" => [
                "bail",
                "required",
                "string",
                "max:100",
                $productUniqueRule,
            ],
            "images" => ["bail", "array"],
            "skus" => ["bail", "required", "array"],
            "skus.*.code" => ["bail", "required", "string"],
            "skus.*.price" => ["bail", "required", " numeric"],
            "skus.*.image" => ["bail", "required", "string"],
        ];
    }
}
