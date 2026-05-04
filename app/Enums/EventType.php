<?php

namespace App\Enums;

enum EventType: string
{
    case OnSite = 'onsite';
    case Online = 'online';
    case Hybrid = 'hybrid';

    public function label(): string
    {
        return match ($this) {
            self::OnSite => 'Presence Training',
            self::Online => 'Online Course',
            self::Hybrid => 'Hybrid Course',
        };
    }
}
