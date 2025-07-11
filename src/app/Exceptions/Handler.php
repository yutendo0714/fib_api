<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
                // 'error' => $exception->getMessage(),
            ], 400);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated.',
                // 'error' => $exception->getMessage(),
            ], 401);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden.',
                // 'error' => $exception->getMessage(),
            ], 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => 404,
                'message' => 'Not found.',
                // 'error' => $exception->getMessage(),
            ], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'status' => 405,
                'message' => 'Method not allowed.',
                // 'error' => $exception->getMessage(),
            ], 405);
        }

        // その他の例外
        return response()->json([
            'status' => 500,
            'message' => 'Internal server error.',
            // 'error' => $exception->getMessage(),
        ], 500);
    }

    public function report(Throwable $exception)
    {
        logger()->error($exception);
        parent::report($exception); // Laravelがログ出力してくれる
    }
}
