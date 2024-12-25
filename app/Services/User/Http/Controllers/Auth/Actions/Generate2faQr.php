<?php

namespace App\Services\User\Http\Controllers\Auth\Actions;

use App\Services\User\Models\User;

class Generate2faQr
{
    public function __construct(private User $user)
    {
    }

    public function getSvg(): string
    {
        $secret = $this->createSecretKey();

        $this->user->save2faSecret($secret);

        $qrCode = app('pragmarx.google2fa')->getQRCodeInline(
            config('app.name'),
            $this->user->mobile,
            $secret,
            200
        );

        return $qrCode;
    }

    public function createSecretKey(): string
    {
        return app('pragmarx.google2fa')->generateSecretKey();
    }
}
