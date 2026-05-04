<?php

namespace App\Models;

use App\Enums\EventType;
use App\Traits\HasDuration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property EventType $type
 * @property Carbon $start_date
 * @property Carbon $end_date
 */
class Event extends Model
{
    use HasDuration {
        getDurationInDays as traitGetDurationInDays;
    }
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'start_date',
        'end_date',
        'location',
    ];

    protected $casts = [
        'type' => EventType::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getDurationInDays(): int
    {
        return $this->traitGetDurationInDays() + 1;
    }
}
