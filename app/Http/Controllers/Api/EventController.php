<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\EventServiceInterface;

class EventController extends ApiController
{

    public function __construct(
        private EventServiceInterface $service,
    ) {}

    public function index()
    {
        $events = $this->service->getEvents();

        dd($events);
    }

    public function get(Event $event)
    {
        dd($event);
    }
}
