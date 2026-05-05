<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Requests\CreateEventRequest;
use App\Models\Event;
use App\Models\Trainer;
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
        return view('events.form', [
            'trainers' => Trainer::all(),
            'types' => EventType::cases(),
        ]);
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
}
