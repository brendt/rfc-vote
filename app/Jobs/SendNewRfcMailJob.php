<?php

namespace App\Jobs;

use App\Actions\SendUserMail;
use App\Mail\NewRfcMail;
use App\Models\Rfc;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewRfcMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Rfc $rfc,
        public User $user,
    ) {
    }

    public function handle(): void
    {
        (new SendUserMail)(
            user: $this->user,
            mailable: new NewRfcMail(
                $this->rfc,
                $this->user,
            ),
        );
    }
}
