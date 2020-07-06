<?php

namespace App\Http\Controllers;

use App\Models\News;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Illuminate\Support\Facades\DB;

class SqlController extends Controller
{
    /**
     * @Get("/sql")
     * @return \Illuminate\Http\JsonResponse
     */
    public function simple()
    {
        DB::connection()->enableQueryLog();

        News::query()->find(1);

        return response()->json(['log' => DB::getQueryLog()]);
    }
}
