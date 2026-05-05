<?php

use App\Http\Controllers\EventController;
use App\Livewire\EventManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/livewire', EventManager::class);

Route::get('/events', [EventController::class, 'index']);
