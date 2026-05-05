<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Trainer;
use Livewire\Component;
use Livewire\WithPagination;

class EventManager extends Component
{
    use WithPagination;

    // Search and View state
    public string $search = '';
    public bool $isEditing = false;
    public ?int $selectedEventId = null;

    // Form inputs
    public string $title = '';
    public string $description = '';
    public string $location = '';
    public $trainer_id;

    protected $rules = [
        'title' => 'required|min:5',
        'description' => 'required',
        'location' => 'required',
        'trainer_id' => 'required|exists:trainers,id',
    ];

    public function edit(int $id)
    {
        $event = Event::findOrFail($id);
        $this->selectedEventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->location = $event->location;
        $this->trainer_id = $event->trainer_id;
        $this->isEditing = true;
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->isEditing) {
            Event::find($this->selectedEventId)->update($data);
            session()->flash('message', 'Event updated!');
        } else {
            Event::create($data);
            session()->flash('message', 'Event created!');
        }

        $this->resetForm();
    }

    public function delete(int $id)
    {
        Event::destroy($id);
        session()->flash('message', 'Event deleted.');
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'location', 'trainer_id', 'isEditing', 'selectedEventId']);
    }

    public function render()
    {
        return view('livewire.event-manager', [
            'events' => Event::with(Event::RELATION_TRAINER) // Eager loading to prevent N+1 issues
                            ->where('title', 'like', "%{$this->search}%")
                            ->latest()
                            ->paginate(8),
            'trainers' => Trainer::all()
        ])->layout('components.layouts.app');
    }
}
