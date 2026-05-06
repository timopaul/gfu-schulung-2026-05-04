<?php

namespace App\Models;

use App\Enums\EventType;
use App\Traits\HasDuration;
use Carbon\Carbon;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder<Event>
 *
 * @property string $title
 * @property string $label
 * @property EventType $type
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property-read Trainer|null $trainer
 *
 * @method static Builder<Event>|self upcoming()
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

    public function __toString(): string
    {
        return $this->label;
    }

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower(trim($value)),
        );
    }

    public function label(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->title} | Ort: {$this->location} ({$this->getDurationInDays()} Tage)",
        );
    }

    public function getDurationInDays(): int
    {
        return $this->traitGetDurationInDays() + 1;
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('start_date', '>=', Carbon::now());
    }

    public function scopeFromTrainer(Builder $query, Trainer $trainer): Builder
    {
        return $query->where('trainer_id', $trainer->getKey());
    }
}
