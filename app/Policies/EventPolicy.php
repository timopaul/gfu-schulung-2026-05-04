<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function update(User|null $user, Event $event): bool
    {
        return 10 <= $event->getKey();
    }

    public function delete(User|null $user, Event $event): bool
    {
        return 10 <= $event->getKey();
    }
}
