<?php


namespace App\Services\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\User\Http\Requests\UpdateUserRequest;
use App\Services\User\Http\Resources\UserResource;
use App\Services\Utils\FileSystem\Models\File;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(UpdateUserRequest $request): UserResource
    {
        $user = trx(function () use ($request) {

            $this->saveFiles($request);

            return tap($request->user())->update($request->validated());
        });

        $user->update(['verified' => false]);

        return new UserResource($user);
    }

    public function saveFiles(Request $request): void
    {
        File::saveFor(
            owner: $request->user(),
            fileObject: $request->national_card,
            flag: File::FLAGS['nationalCard']
        );

        File::saveFor(
            owner: $request->user(),
            fileObject: $request->national_id,
            flag: File::FLAGS['nationalId']
        );

        File::saveFor(
            owner: $request->user(),
            fileObject: $request->passport_file,
            flag: File::FLAGS['passport']
        );

        File::saveFor(
            owner: $request->user(),
            fileObject: $request->selfie_video_file,
            flag: File::FLAGS['selfieVideo']
        );
    }
}
