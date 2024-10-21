<?php

namespace Modules\Order\Domain\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Order\Domain\Repositories\IOrderRepository;

class CodeUniqueRule implements ValidationRule
{

    public function __construct(protected IOrderRepository $orderRepository){}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->orderRepository->codeExists($value)) {
            $fail('The :attribute is already taken!');
        }
    }
}
