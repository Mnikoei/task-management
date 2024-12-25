<?php

namespace App\Services\User\Jobs;

use App\Services\Inquiry\NationalCode\Clients\Jibimo\DepositId;
use App\Services\Inquiry\NationalCode\Clients\Jibimo\Inquiry;
use App\Services\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateDepositId implements ShouldQueue
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
        $response = $this->getClient()->generate();
        $this->user->update(['deposit_id' => $response->getDepositid()]);
    }

    public function getClient(): DepositId
    {
        return (new DepositId(
            $this->getFirstName(),
            $this->getLastName(),
            $this->user->national_code,
            $this->user->mobile,
        ));
    }

    public function getFirstName(): string
    {
        return $this->user->name;
    }

    public function getLastName(): string
    {
        return Str::substr($this->user->name, mb_strlen($this->user->name) / 2) ?: '';
    }
}
