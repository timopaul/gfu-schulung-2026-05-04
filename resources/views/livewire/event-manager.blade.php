<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Sidebar: CRUD Form -->
    <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold mb-6 text-gray-800">
            {{ $isEditing ? 'Event bearbeiten' : 'Neues Event' }}
        </h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Titel</label>
                <input type="text" wire:model="title" class="w-full border p-2 rounded-lg mt-1">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Beschreibung</label>
                <textarea wire:model="description" class="w-full border p-2 rounded-lg mt-1"></textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Typ</label>
                <select wire:model="type" class="w-full border p-2 rounded-lg mt-1">
                    <option value="">Wähle Typ...</option>
                    @foreach(\App\Enums\EventType::cases() as $eventType)
                        <option value="{{ $eventType->value }}">{{ $eventType->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Trainer</label>
                <select wire:model="trainer_id" class="w-full border p-2 rounded-lg mt-1">
                    <option value="">Wähle Trainer...</option>
                    @foreach($trainers as $trainer)
                        <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                    @endforeach
                </select>
                @error('trainer_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Startdatum</label>
                <input type="date" id="start_date" wire:model="start_date" class="w-full border p-2 rounded-lg mt-1">
                @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Enddatum</label>
                <input type="date" id="end_date" wire:model="end_date" class="w-full border p-2 rounded-lg mt-1">
                @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Ort</label>
                <input type="text" wire:model="location" class="w-full border p-2 rounded-lg mt-1">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                {{ $isEditing ? 'Speichern' : 'Anlegen' }}
            </button>

            @if($isEditing)
                <button type="button" wire:click="resetForm" class="w-full text-gray-500 text-sm py-2">Abbrechen</button>
            @endif
        </form>
    </div>

    <!-- Main List & Search -->
    <div class="lg:col-span-3 bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <input type="text" wire:model.live="search" placeholder="Events filtern..." class="w-full border p-3 rounded-xl mb-6 outline-none focus:ring-2 focus:ring-blue-500">

        @if(session()->has('message'))
            <div class="p-4 bg-green-50 text-green-700 rounded-lg mb-6 border border-green-100 italic">
                {{ session('message') }}
            </div>
        @endif

        <table class="w-full text-left">
            <thead class="text-gray-400 uppercase text-xs border-b">
            <tr>
                <th class="pb-3 px-2">Titel</th>
                <th class="pb-3">Trainer</th>
                <th class="pb-3 text-right px-2">Aktionen</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
            @foreach($events as $event)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 px-2 font-bold">{{ $event->title }}</td>
                    <td class="py-4">{{ $event->trainer->name ?? 'Kein Trainer' }}</td>
                    <td class="py-4 text-right px-2">
                        <button wire:click="edit({{ $event->id }})" class="text-blue-600 hover:underline">Edit</button>
                        <button wire:click="delete({{ $event->id }})" wire:confirm="Löschen?" class="text-red-400 hover:text-red-600 ml-4">Löschen</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-6">{{ $events->links() }}</div>
    </div>
</div>
