<?php


namespace App\Services\User\Http\Controllers\Auth\Actions;

use App\Services\Order\Currency\Currency;
use App\Services\User\Http\Requests\RegisterRequest;
use App\Services\User\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function registerUser(RegisterRequest $request): User
    {
        $data = $request->validated();

        $user = new User();
        $user->name = $data['name'];
        $user->mobile = $data['mobile'];
        $user->national_code = $data['national_code'];
        // hash this later :)
        $user->birth_day = Carbon::parse($data['birth_date'])->toDateTimeString();
        $user->password = Hash::make($data['password']);

        trx(function () use ($user) {
            $user->save();
            $user->wallets()->create([
                'name' => 'کیف پول ریالی',
                'balance' => 0,
                'currency' => Currency::RIAL,
                'address' => ''
            ]);

//            dispatch(new InquiryShahkar($user));
        });

        return $user;
    }
}
