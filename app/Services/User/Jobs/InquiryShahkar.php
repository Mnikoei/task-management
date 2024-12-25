<?php

namespace App\Services\User\Jobs;

use App\Services\Inquiry\NationalCode\Clients\Jibimo\InquiryShahkar as InquiryShahkarClient;
use App\Services\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InquiryShahkar implements ShouldQueue
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
    public function handle(): void
    {
        $response = $this->getClient()->inquiry();

        if ($response->isMatch()) {
            $this->user->setAsShahkarMatch();
        }

        if ($response->isNotMatch()) {
            $this->user->setAsShahkarDoesntMatch();
            $this->user->addRejectionReason('کد ملی و شماره موبایل همخوانی ندارند');
        }

        if (!$response->httpSucceeded()) {
            $this->user->setAsShahkarInquiryFailed();
        }
    }

    public function getClient(): InquiryShahkarClient
    {
        return (new InquiryShahkarClient(
            phoneNumber: $this->user->mobile,
            nationalCode: $this->user->national_code,
        ));
    }
}
