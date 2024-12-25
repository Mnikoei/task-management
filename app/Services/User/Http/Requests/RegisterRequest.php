<?php


namespace App\Services\User\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'national_code' => 'required|numeric|nationalCode|unique:users',
            'birth_date' => 'required|date',
            'password' => 'required|string|min:6',
            'mobile' => 'required|string|mobile'
        ];
    }
}
