<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Api;
use App\Livewire\EventManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

#Route::get('/livewire', EventManager::class);

Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])
    ->name('events.create');
Route::post('/events', [EventController::class, 'store'])
    ->name('events.store');
Route::get('/events/edit/{event}', [EventController::class, 'edit'])
    ->name('events.edit');
Route::post('/events/{event}', [EventController::class, 'save'])
    ->name('events.save');
Route::get('/events/remove/{event}', [EventController::class, 'remove'])
    ->name('events.remove');

Route::prefix('api')->group(function () {
    Route::get('/events', [Api\EventController::class, 'index']);
    Route::get('/trainers', [Api\TrainerController::class, 'index']);
    Route::get('/trainers/{trainer}', [api\TrainerController::class, 'get']);
});

// Chart Routes
Route::prefix('charts')
    ->name('charts.')
    ->middleware(['can:access-charts'])
    ->group(function () {
        Route::get('/event-statistics', [ChartController::class, 'eventStatistics'])
            ->name('eventStatistics');

        Route::get('/event-statistics/pdf', [ChartController::class, 'eventStatisticsPdf'])
            ->name('eventStatisticsPdf');

        Route::get('/event-statistics/html', [ChartController::class, 'eventStatisticsHtml'])
            ->name('eventStatisticsHtml');
    });
