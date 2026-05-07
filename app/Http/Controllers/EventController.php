<?php

namespace App\Http\Controllers;

use App\Data\EventData;
use App\Enums\EventType;
use App\Exceptions\UnableToCreateEventException;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\EditEventRequest;
use App\Interfaces\Services\EventServiceInterface;
use App\Models\Event;
use App\Models\Tag;
use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        protected EventServiceInterface $service,
    ) {}

    public function index(): View
    {
        $events = $this->service->getEvents();

        return view('events.index', [
            'title' => 'GFU Training Schedule',
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        return $this->form();
    }

    public function store(EventData $data)
    {
        $redirection = redirect()->route('events.index');

        try {
            $event = $this->service->createEvent($data);
        } catch (UnableToCreateEventException $e) {
            return $redirection->with('error', __('Unable to create event.'));
        }

        return $redirection->with('success', __('Event created successfully.', ['event' => $event]));

    }

    public function edit(Event $event): View
    {
        return $this->form([
            'event' => $event,
        ]);
    }

    private function form(array $data = []): View
    {
        return view('events.form', array_merge([
            'trainers' => Trainer::all(),
            'types' => EventType::cases(),
            'tags' => Tag::all(),
        ], $data));
    }

    public function save(Event $event, EditEventRequest $request)
    {
        $data = $request->validated();

        $event->fill($data);

        $event->tags()->sync($data['tags']);

        $redirection = redirect()->route('events.index');

        if ($event->save()) {
            return $redirection->with('success', __('Event ":event" updated successfully.', ['event' => $event]));
        }

        return $redirection->with('error', __('Unable to update event ":event".', ['event' => $event]));
    }

    public function remove(Event $event): RedirectResponse
    {
        $redirection = redirect()->route('events.index');

        if ($event->delete()) {
            $redirection->with('success', __('Event ":event" removed successfully.', ['event' => $event]));
        } else {
            $redirection->with('error', __('Unable to remove event ":event".', ['event' => $event]));
        }

        return $redirection;
    }
}
