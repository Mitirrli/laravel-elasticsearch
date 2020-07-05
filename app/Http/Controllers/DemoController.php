<?php

namespace App\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    /**
     * @Get("/")
     */
    public function index(Request $request)
    {
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);
    }
}
