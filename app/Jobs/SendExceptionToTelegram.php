<?php

namespace App\Jobs;

use App\Actions\SendExceptionToTelegramAction;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendExceptionToTelegram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Exception $exception,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(SendExceptionToTelegramAction $action): void
    {
        $action = new SendExceptionToTelegramAction($this->exception);

        $action->send();
    }
}
