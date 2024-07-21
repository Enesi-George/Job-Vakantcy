<?php

namespace App\Http\Requests;

use App\Data\UserDTO;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Redirect back with errors
        throw new HttpResponseException(Redirect::back()->withErrors($errors)->withInput());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'unique:users,name', 
                'min:3',
                'regex:/^[A-Z][a-z]+\s[A-Z][a-z]+$/'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ]
        ];
    }
    

    public function messages(): array
    {
        return [
            'name.regex' => 'The name field must be in the format "First Last" with each name starting with a capital letter.',
            'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ];
    }

    public function userData(): UserDTO
    {
        return new UserDTO(
            name: $this->name,
            email: $this->email,
            password: $this->password
        );
    }
}
