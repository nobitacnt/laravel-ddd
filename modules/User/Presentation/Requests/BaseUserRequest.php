<?php
namespace Modules\User\Presentation\Requests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Shared\Presentation\Requests\BaseRequest;
use Modules\User\Domain\Rules\EmailUniqueRule;

class BaseUserRequest extends BaseRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $message = __('The given data was invalid.');

        throw new HttpResponseException(response()->json([
            'message' => $message,
            'errors' => $errors,
        ], 422));
    }

    public function rules(EmailUniqueRule $emailUniqueRule): array
    {
        return [
            "email" => [
                "bail",
                "required",
                "string",
                "email",
                "max:100",
                $emailUniqueRule,
            ],
            "name" => ["bail", "required", "max:100", "min:5"],
        ];
    }

    public function messages(): array
    {
        return [
            //'name.*' => __('Name is not valid'),
        ];
    }
}
