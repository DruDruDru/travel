<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StorePlaceRequest extends FormRequest
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
            'name' => 'required|max:255|string|unique:places,name',
            'longitude' => 'required|decimal:7|min:-180|max:180',
            'latitude' => 'required|decimal:7|min:-90|max:90'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Поле name обязательно',
            'name.max' => 'Поле name не может быть более 255 символов',
            'name.string' => 'Поле name должно быть строкового типа',
            'name.unique' => 'Такое имя места отдыха уже занято',
            'longitude.required' => 'Долгота обязательна для заполнения',
            'longitude.decimal' => 'Долгота должна быть в точности до 7 знаков после точки',
            'longitude.min' => 'Долгота должна быть более -180',
            'longitude.max' => 'Долгота должна быть менее 180',
            'latitude.required' => 'Широта обязательна для заполнения',
            'latitude.decimal' => 'Широта должна быть в точности до 7 знаков после точки',
            'latitude.min' => 'Широта должна быть более -90',
            'latitude.max' => 'Широта должна быть менее 90',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return throw new ValidationException($validator, response()->json([
            'error' => [
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
