<?php


namespace App\Services\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\Http\Resources\Auth\TokenResource;
use App\Services\User\Http\Resources\LoginUserResource;
use App\Services\User\Http\Resources\RegisterUserResource;
use Facades\App\Services\User\Http\Controllers\Auth\Actions\Register;
use App\Services\User\Http\Requests\LoginRequest;
use App\Services\User\Http\Requests\RegisterRequest;
use Facades\App\Services\User\Http\Controllers\Auth\Actions\Login;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $accessToken = Login::loginUser($request->username, $request->password);

        abort_if(is_null($accessToken), 401, 'Invalid Credentials!');

        return new TokenResource($accessToken);
    }

    public function register(RegisterRequest $request)
    {
        $user = Register::registerUser($request);

        return new RegisterUserResource($user);
    }
}
