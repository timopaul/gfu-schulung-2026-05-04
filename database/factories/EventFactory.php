<?php

namespace Database\Factories;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentYear = Carbon::now()->year;
        $yearStart = Carbon::create($currentYear, 1, 1);
        $yearEnd = Carbon::create($currentYear, 12, 31);

        // Zufälliges Startdatum im aktuellen Jahr
        $startDate = $this->faker->dateTimeBetween(
            $yearStart->toDateTimeString(),
            $yearEnd->toDateTimeString()
        );
        $startDate = Carbon::instance($startDate);

        // Wenn Wochenende, auf Montag verschieben
        while ($startDate->isWeekend()) {
            $startDate->addDay();
        }

        // Enddatum in der gleichen Woche (maximal 5 Tage später)
        $maxDaysInWeek = $startDate->diffInDays($startDate->copy()->endOfWeek());
        $daysToAdd = $this->faker->numberBetween(0, min(5, $maxDaysInWeek));
        $endDate = $startDate->copy()->addDays($daysToAdd);

        // Wenn Enddatum Wochenende ist, auf Freitag zurück
        while ($endDate->isWeekend() || $endDate->greaterThan($startDate->copy()->endOfWeek())) {
            $endDate->subDay();
        }

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(EventType::cases()),
            'location' => $this->faker->city(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'trainer_id' => Trainer::factory(),
        ];
    }
}
