<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad request.',
            ], 400);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden.',
            ], 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => 404,
                'message' => 'Not found.',
            ], 404);
        }

        // その他の例外（フォールバック）
        return response()->json([
            'status' => 500,
            'message' => 'Internal server error.',
        ], 500);
    }
}
