<?php

namespace App\Models;

use App\Enums\EventType;
use App\Traits\HasDuration;
use Carbon\Carbon;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property EventType $type
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property-read Trainer|null $trainer
 */
class Event extends Model
{
    use HasDuration {
        getDurationInDays as traitGetDurationInDays;
    }

    /** @use HasFactory<EventFactory> */
    use HasFactory;

    use SoftDeletes;

    const string RELATION_TRAINER = 'trainer';

    protected $fillable = [
        'trainer_id',
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

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }
}
