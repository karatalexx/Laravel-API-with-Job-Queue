<?php

namespace App\Listeners;

use App\Events\MessageCreateEvent;
use Exception;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class MessageLogListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            MessageCreateEvent::class => 'handle',
        ];
    }

    /**
     * Handle the event.
     */
    public function handle(MessageCreateEvent $event): void
    {
        Log::debug(
            'Message saved successfully',
            ['name' => $event->message->name, 'email' => $event->message->email]
        );
    }
}
