<?php

namespace App\Services;

use App\Exceptions\UnableToCreateEventException;
use App\Interfaces\Services\EventServiceInterface;
use App\Models\Event;
use App\Models\Trainer;
use Illuminate\Support\Collection;

class EventService implements EventServiceInterface
{
    public function getEvents(): Collection
    {
        //return Event::query()->with(Event::RELATION_TRAINER)->get();
        //return Event::upcoming()->with(Event::RELATION_TRAINER)->get();
        $trainer = Trainer::find(2);
        return Event::fromTrainer($trainer)
            ->with(Event::RELATION_TRAINER)
            ->with(Event::RELATION_TAGS)
            ->get();
        //return Event::upcoming()->fromTrainer($trainer)->with(Event::RELATION_TRAINER)->get();
    }

    /**
     * @throws UnableToCreateEventException
     */
    public function createEvent(array $data): Event
    {
        $event = new Event();
        $event->fill($data);

        if ( ! $event->save()) {
            throw new UnableToCreateEventException();
        }

        // @TODO send mail to Trainer

        // @TODO Book a room

        return $event;
    }

    public function updateEvent(Event $event, array $data): Event
    {
        $event->fill($data);
        $event->save();

        return $event;
    }

    public function deleteEvent(Event $event): bool
    {
        return (bool) $event->delete();
    }
}
