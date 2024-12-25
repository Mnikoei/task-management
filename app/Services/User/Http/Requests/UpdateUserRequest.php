<?php


namespace App\Services\User\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'national_code' => 'required|string|max:10|nationalCode',
            'mobile' => 'required|mobile',
            'address_ir' => 'required|string|max:400',
            'address_out_of_ir' => 'required|string|max:400',
            'postal_code_ir' => 'required|string|numeric',
            'phone' => 'required|string|max:15',
            'national_card' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,jfif,bmp'],
            'national_id' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,jfif,bmp'],
            'passport_file' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,jfif,bmp'],
            'selfie_video_file' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,jfif,bmp'],
        ];
    }
}
