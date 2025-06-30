<?php

namespace App\Http\Controllers;

use App\Http\Requests\FibonacciRequest;
use App\Services\FibonacciService;
use Illuminate\Http\JsonResponse;

class FibonacciController extends Controller
{
    public function index(FibonacciRequest $request, FibonacciService $fibonacciService): JsonResponse
    {
        $attributes = $request->only(['n']);
        $n = $attributes['n'];

        $result = $fibonacciService->fibonacci($n);
        return response()->json(['result' => $result]);
    }
}
