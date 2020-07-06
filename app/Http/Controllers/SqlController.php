<?php

namespace App\Http\Controllers;

use App\Models\News;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Illuminate\Support\Facades\DB;

class SqlController extends Controller
{
    /**
     * @Get("/simple")
     * @return \Illuminate\Http\JsonResponse
     */
    public function simple()
    {
        News::query()->find(1);
        News::query()->find(2);
    }

    /**
     * @Get("/complex")
     */
    public function complex()
    {

    }
}
