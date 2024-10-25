<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
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
            'login' => 'required|string|max:255|unique:users,login',
            'password' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'Поле login обязательное для заполнения',
            'login.string' => 'Поле login должно быть строкого типа',
            'login.max' => 'Максимальное кол-во символов поля login 255',
            'login.unique' => 'Такой login уже занят',
            'password.required' => 'Поле password обязательно для заполнения',
            'password.string' => 'Поле password должно быть строкого типа',
            'password.max' => 'Максимальное кол-во символов поля password 255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'error' => [
                'status_code' => 422,
                'message' => 'Ошибка валидации',
                'details' => $validator->errors()
            ],
        ], 422));
    }

    public function expectsJson(): bool
    {
        return true;
    }
}
