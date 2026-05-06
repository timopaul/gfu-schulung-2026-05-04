<?php

namespace App\Http\Requests;

use App\Enums\EventType;
use App\Models\Tag;
use App\Models\Trainer;
use App\Rules\NoWeekends;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

class CreateEventRequest extends CustomRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $trainerModel = new Trainer;
        $trainersTable = $trainerModel->getTable();
        $trainersKey = $trainerModel->getKeyName();

        $tagModel = new Tag;
        $tagsTable = $tagModel->getTable();
        $tagsKey = $tagModel->getKeyName();

        return [
            'title' => ['required', 'string', 'min:5', 'max:191'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string', new Enum(EventType::class)],
            'start_date' => ['required', 'date', new NoWeekends()],
            'end_date' => ['required', 'date', 'after_or_equal:start_date', 'no_weekends'],
            'location' => ['required', 'string'],
            'trainer_id' => ['required', "exists:{$trainersTable},{$trainersKey}"],
            'tags' => ['array'],
            'tags.*' => ['integer', "exists:{$tagsTable},{$tagsKey}"],
        ];
    }
}
