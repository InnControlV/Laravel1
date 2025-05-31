<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

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
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'code' => method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500
            ], method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
        }

        return parent::render($request, $exception);
    }

    public function register(): void
    {


        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
{


    return response()->json([
        'error' => true,
        'message' => 'Unauthenticated',
        'code' => 401,
    ], 401);
}
}
