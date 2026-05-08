<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tag;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $tags = Tag::all()->isEmpty() ? Tag::factory(100)->create() : Tag::all();

        $trainers = Trainer::all()->isEmpty() ? Trainer::factory(20)->create() : Trainer::all();

        $trainers->each(function (Trainer $trainer) use ($tags) {
            $trainer->tags()->sync(
                $tags->random(rand(1, 3))->pluck((new Tag)->getKeyName())->all()
            );
        });

        $events = Event::factory(500)->create([
            'trainer_id' => fn() => $trainers->random()->getKey(),
        ]);
        $events->each(function (Event $event) use ($tags) {
            $event->tags()->sync(
                $tags->random(rand(3, 5))->pluck((new Event)->getKeyName())->all()
            );
        });
    }
}
