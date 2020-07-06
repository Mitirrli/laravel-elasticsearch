<?php

namespace App\Providers;

use Illuminate\Http\Request;
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
    public function boot(Request $request)
    {
        if (env('APP_ENV') === 'local') {
            DB::listen(function ($query) use ($request) {
                if($request->has('sql-debug')){
                    $sql = vsprintf(str_replace('?', '%s', $query->sql) . ', time: ' . $query->time, $query->bindings);

                    Log::debug($sql);
                }
            });
        }
    }
}
