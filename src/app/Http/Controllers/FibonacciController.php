<?php

namespace App\Http\Controllers;

use App\Http\Requests\FibonacciRequest;
use App\Services\FibonacciService;

class FibonacciController extends Controller
{
    public function index(FibonacciRequest $request, FibonacciService $fibonacciService)
    {
        $attributes = $request->only(['n']);
        $n = $attributes['n'];

        $result = $fibonacciService->fibonacci($n);
        return response()->json(['result' => $result]);
    }
}
