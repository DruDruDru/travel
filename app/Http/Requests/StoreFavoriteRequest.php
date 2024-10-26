<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreFavoriteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'place_id' => 'required|uuid|exists:places,id',
            'user_id' => 'uuid'
        ];
    }

    public function messages(): array
    {
        return [
            'place_id.required' => '',
            'place_id.uuid' => 'Идентификатор места отдыха должен быть корректным',
            'place_id.exists' => 'Данного места отдыха не существует',
            'user_id.uuid' => 'Идентификатор пользователя должен быть корректным',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->route('user_id')
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        return throw new ValidationException($validator, response()->json([
            "error" => [
                'status_code' => 422,
                'message' => 'Ошибка валидации',
                'details' => $validator->errors()
            ]
        ], 422));
    }

    public function expectsJson()
    {
        return true;
    }
}
