<?php

namespace App\Traits;

trait HasDuration
{
    public function getDurationInDays(): int
    {
        return $this->start_date->diffInDays($this->end_date);
    }
}
