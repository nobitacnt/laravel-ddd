<?php

namespace Modules\Product\Domain\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Product\Domain\Repositories\IProductRepository;

class CodeUniqueRule implements ValidationRule
{

    public function __construct(protected IProductRepository $productRepository){}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->productRepository->codeExists($value)) {
            $fail('The :attribute is already taken!');
        }
    }
}
