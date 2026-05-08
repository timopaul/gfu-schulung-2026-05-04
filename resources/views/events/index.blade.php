@extends('layout.app')

@section('title', 'Upcoming Events')

@section('content')
    <header class="mb-10 flex justify-between items-center">
        <h1 class="text-4xl font-extrabold text-slate-800 tracking-tight">
            {{ $title }}
        </h1>
        <span class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-semibold ml-auto">
            {{ $events->count() }} Events found
        </span>
        <a href="{{ route('charts.eventStatistics') }}" title="View Event Statistics Chart" class="ml-3">
            <button class="bg-green-500 hover:bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                </svg>
            </button>
        </a>
        <a href="{{ route('events.create') }}" title="Create New Event" class="ml-3">
            <button class="bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </a>
    </header>

    <div class="grid gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">

                <div class="flex flex-wrap gap-2">
                    @foreach($event->tags as $tag)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>

                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $event->title }}</h2>
                        <p class="text-slate-600 mt-2">{{ $event->description }}</p>
                    </div>
                    <!-- Using our Enum Label -->
                    <span class="px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider {{ $event->type->value === 'onsite' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700' }}">
                        {{ $event->type->label() }}
                    </span>
                </div>

                <div class="mt-6 flex items-center gap-6 text-sm text-slate-500">
                    <div class="flex items-center gap-1">
                        <span>📍</span> {{ $event->location }}
                    </div>
                    @if(null !== $event->trainer)
                        <div class="flex items-center gap-1">
                            <span>🧑</span> {{ $event->trainer->name }}
                        </div>
                    @endif
                    <div class="flex items-center gap-1">
                        <span>⏱</span>
                        <!-- Using our Trait Method -->
                        Duration: {{ $event->getDurationInDays() }} Days
                    </div>
                    <div class="flex items-center gap-1">
                        <span>📅</span>
                        <!-- Using Carbon Casting -->
                        {{ $event->start_date->format('D, d.M Y') }}
                    </div>
                    <div class="flex items-right gap-1 ml-auto">
                        <a href="{{ route('events.edit', ['event' => $event]) }}">✍ bearbeiten</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 text-center rounded-xl shadow-sm border-2 border-dashed border-slate-300">
                <p class="text-slate-500">No events scheduled yet. Time to use Tinker!</p>
            </div>
        @endforelse
    </div>
@endsection
