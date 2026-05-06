<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\EditEventRequest;
use App\Models\Event;
use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()->with(Event::RELATION_TRAINER)->get();

        return view('events.index', [
            'title' => 'GFU Training Schedule',
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        return $this->form();
    }

    public function store(CreateEventRequest $request)
    {
        $data = $request->validated();

        $event = new Event();
        $event->fill($data);

        $redirection = redirect()->route('events.index');

        if ($event->save()) {
            return $redirection->with('success', 'Event created successfully.');
        }

        return $redirection->with('error', 'Unable to create event.');
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
        ], $data));
    }

    public function save(Event $event, EditEventRequest $request)
    {
        $data = $request->validated();

        $event->fill($data);

        $redirection = redirect()->route('events.index');

        if ($event->save()) {
            return $redirection->with('success', 'Event updated successfully.');
        }

        return $redirection->with('error', 'Unable to update event.');
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
