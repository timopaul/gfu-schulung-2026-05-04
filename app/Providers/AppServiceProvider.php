<?php

namespace App\Providers;

use App\Interfaces\Services\EventServiceInterface;
use App\Rules\NoWeekends;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EventServiceInterface::class, EventService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // query logger
        if (config('app.debug')) {
            DB::listen(function (QueryExecuted $query) {
                Log::channel('query')->info('-- ' . date('Y-m-d H:i:s'));
                Log::channel('query')->info($query->toRawSql());
                Log::channel('query')->info("Zeit: {$query->time}ms");
            });
        }

        Validator::extend('no_weekends', function ($attribute, $value, $parameters, $validator) {
            $error = null;

            (new NoWeekends)->validate($attribute, $value, function ($message) use (&$error) {
                $error = $message;
            });

            return is_null($error);
        });
    }
}
