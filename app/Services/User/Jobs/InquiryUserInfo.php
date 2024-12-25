<?php

namespace App\Services\User\Jobs;

use App\Services\Inquiry\NationalCode\Clients\Jibimo\Inquiry;
use App\Services\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class InquiryUserInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $response = $this->getClient()->inquiry();

            if ($response->isMatch()) {
                $this->user->setAsVerified();
                dispatch_sync(new GenerateDepositId($this->user));
            }
        });
    }

    public function getClient(): Inquiry
    {
        return (new Inquiry(
            $this->user->national_code,
            $this->user->birth_day,
            $this->user->name
        ));
    }
}
