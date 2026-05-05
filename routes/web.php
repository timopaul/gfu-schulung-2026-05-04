<?php

use App\Http\Controllers\EventController;
use App\Livewire\EventManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/events', EventManager::class);
