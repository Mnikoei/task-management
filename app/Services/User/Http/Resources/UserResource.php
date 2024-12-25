<?php

namespace App\Services\User\Http\Resources;

use App\Services\Utils\FileSystem\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'verified' => $this->verified,
            'deposit_id' => $this->deposit_id,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'national_code' => $this->national_code,
            'birth_day' => $this->birth_day,
            'address_ir' => $this->address_ir,
            'address_out_of_ir' => $this->address_out_of_ir,
            'postal_code_ir' => $this->postal_code_ir,
            'phone' => $this->phone,
            'rejection_reason' => $this->rejection_reason,
            'national_card_url' => $this->files?->where('flag', File::FLAGS['nationalCard'])->last()?->url,
            'national_id_url' => $this->files?->where('flag', File::FLAGS['nationalId'])->last()?->url,
            'passport_url' => $this->files?->where('flag', File::FLAGS['passport'])->last()?->url,
            'selfie_video_url' => $this->files?->where('flag', File::FLAGS['selfieVideo'])->last()?->url,
        ];
    }
}
