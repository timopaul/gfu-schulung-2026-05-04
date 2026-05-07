<?php

namespace App\Interfaces\Services;

use App\Data\EventData;
use App\Models\Event;
use Illuminate\Support\Collection;

interface EventServiceInterface
{
    public function getEvents(): Collection;

    public function createEvent(EventData $data): Event;

    public function updateEvent(Event $event, array $data): Event;

    public function deleteEvent(Event $event): bool;
}
