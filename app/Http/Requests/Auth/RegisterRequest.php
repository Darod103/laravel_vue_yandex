<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name'     => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email обязателен для заполнения.',
            'email.email'    => 'Введите корректный адрес электронной почты.',
            'email.max'      => 'Email не должен превышать 255 символов.',
            'email.unique'   => 'Пользователь с таким email уже зарегистрирован.',

            'password.required'  => 'Пароль обязателен для заполнения.',
            'password.min'       => 'Пароль должен содержать не менее 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',

            'name.required' => 'Имя обязательно для заполнения.',
            'name.max'      => 'Имя не должно превышать 255 символов.',
        ];
    }
}
