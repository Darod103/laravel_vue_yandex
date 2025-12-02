<?php

namespace App\Http\Requests\Reviews;

use App\DTO\ParsePlaceDto;
use Illuminate\Foundation\Http\FormRequest;

class ReviewsStoreRequest extends FormRequest
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
            'url' => 'required|url|starts_with:https://yandex.ru/maps',
        ];
    }

    public function messages(): array
    {
        return [
            'url.required'    => 'Пожалуйста, введите ссылку на Яндекс.Карты.',
            'url.url'         => 'Некорректный формат ссылки.',
            'url.starts_with' => 'Ссылка должна начинаться с https://yandex.ru/maps',
        ];
    }

    public function toDto()
    {
        $data = $this->validated();

        return new ParsePlaceDto(
            userId: $this->user()->id,
            url: $data['url'],
        );
    }
}
