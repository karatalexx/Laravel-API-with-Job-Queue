<?php

namespace App\Jobs;

use App\Models\Message;
use App\Services\MessagesService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MessageProcessJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Message $message,
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(MessagesService $messagesService): void
    {
        $messagesService->create($this->message->toArray());
    }
}
