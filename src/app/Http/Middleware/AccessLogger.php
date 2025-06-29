<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AccessLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $arrLog = [
            "REQUEST URI: " => $request->getUri(),
            "REQUEST METHOD: " => $request->getMethod(),
            "REQUEST HEADER: " => json_encode($request->header()),
            "REQUEST BODY: " => json_encode($request->all()),
        ];

        Log::info('リクエストスタート', $arrLog);

        $response = $next($request);

        $arrLog = [
            "RESPONSE STATUS: " => $response->getStatusCode(),
            "RESPONSE HEADER: " => json_encode($response->headers),
            "RESPONSE BODY: " => $response->getContent(),
        ];

        Log::info('リクエスト終了', $arrLog);
        Log::info("\n\n");

        return $response;
    }
}
