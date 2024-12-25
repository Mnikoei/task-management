<?php


namespace App\Services\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\Http\Controllers\Auth\Actions\Generate2faQr;
use App\Services\User\Http\Resources\LoginUserResource;
use App\Services\User\Http\Resources\RegisterUserResource;
use Facades\App\Services\User\Http\Controllers\Auth\Actions\Register;
use App\Services\User\Http\Requests\LoginRequest;
use App\Services\User\Http\Requests\RegisterRequest;
use Facades\App\Services\User\Http\Controllers\Auth\Actions\Login;
use App\Services\User\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = Login::loginUser($request->username, $request->password);

        return $user
            ? response(new LoginUserResource($user))
            : response()->json(['message' => __('auth.user.invalid-credentials')], 401);
    }

    public function register(RegisterRequest $request)
    {
        $user = Register::registerUser($request);

        Login::login($user);

        return new RegisterUserResource($user);
//        return [
//            'register_2fa' => true,
//            'qr_svg' => (new Generate2faQr($user))->getSvg()
//        ];
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json(['message' => __('auth.user.log-out-msg')]);
    }
}
