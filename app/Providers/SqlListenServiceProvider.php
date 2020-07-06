<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class SqlListenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'local') {
            DB::listen(function ($query) {
                $sql = vsprintf(str_replace('?', '%s', $query->sql), $query->bindings);

                Log::debug($sql);
            });
        }
    }
}
