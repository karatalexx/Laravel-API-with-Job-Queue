<?php

namespace App\Services;

use App\Events\MessageCreateEvent;
use App\Models\Message;
use Symfony\Component\Mailer\Event\MessageEvent;

class MessagesService
{
    public function create(array $data): object
    {
        $entity = Message::query()->create($data);

        MessageCreateEvent::dispatch($entity);

        return (object)$entity->toArray();
    }
}
