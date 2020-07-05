<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use Collective\Annotations\Routing\Annotations\Annotations\Get;

class DemoController extends Controller
{
    /**
     * @Get("/")
     * @param TestRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TestRequest $request)
    {
        $params = $request->validated();

        return response()->json($params);
    }
}
