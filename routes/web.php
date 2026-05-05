<?php

use App\Http\Controllers\EventController;
use App\Livewire\EventManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/livewire', EventManager::class);

Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])
    ->name('events.create');
Route::post('/events', [EventController::class, 'store'])
    ->name('events.store');
