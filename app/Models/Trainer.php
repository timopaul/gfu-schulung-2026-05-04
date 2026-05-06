<?php

namespace App\Models;

use Database\Factories\TrainerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property string $email
 *
 * @property-read Collection<int, Event> $events
 */
class Trainer extends Model
{
    /** @use HasFactory<TrainerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
