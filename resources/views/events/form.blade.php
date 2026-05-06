@extends('layout.app')

@section('title', isset($event) ? 'Edit Event' : 'Create New Event')

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-6 text-gray-800">{{ isset($event) ? 'Edit Event' : 'Create Event' }}</h2>

            <form action="{{ isset($event) ? route('events.save', ['event' => $event]) : route('events.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Event Titel</label>
                    <input type="text" name="title" value="{{ old('title', isset($event) ? $event->title : null) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Beschreibung</label>
                    <textarea name="description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">{{ old('description', isset($event) ? $event->description : null) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trainer (Select) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Trainer</label>
                    <select name="trainer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                        <option value="" class="hidden">-- Trainer auswählen --</option>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->getKey() }}" {{ old('trainer_id', isset($event) ? $event->trainer?->getKey() : null) == $trainer->getKey() ? 'selected' : '' }}>
                                {{ $trainer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('trainer_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" value="{{ old('location', isset($event) ? $event->location : null) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type (Enum Selection / Radio) -->
                <div class="py-2">
                    <span class="block text-sm font-medium text-gray-700 mb-2">Event Typ</span>
                    <div class="flex gap-4">
                        @foreach($types as $type)
                            <label class="inline-flex items-center">
                                <input type="radio" name="type" value="{{ $type->value }}"
                                    class="text-blue-600 focus:ring-blue-500" {{ old('type', isset($event) ? $event->type->value : null) == $type->value ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ $type->label() }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dates (Start & End) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Startdatum</label>
                        <input type="date" name="start_date" value="{{ old('start_date', isset($event) ? $event->start_date->format('Y-m-d') : null) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Enddatum</label>
                        <input type="date" name="end_date" value="{{ old('end_date', isset($event) ? $event->end_date->format('Y-m-d') : null) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <a href="{{ url()->previous() }}" class="gap-x-2 text-sm inline-flex items-center rounded-lg bg-white text-gray-700 hover:text-gray-900 transition-all px-6 py-2 shadow-sm ring-1 ring-inset ring-gray-300 hover:ring-gray-500 hover:bg-gray-50 mr-4">zurück</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-md">
                        {{ isset($event) ? 'aktualisieren' : 'speichern' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
