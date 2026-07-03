<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // Handle authentication exceptions FIRST (before checking expectsJson)
        if ($e instanceof AuthenticationException) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthorized - Please login first',
                    'error' => 'Unauthenticated',
                ], 401);
            }
        }

        // Handle JSON API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            // Handle validation exceptions
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }

            // Handle HTTP exceptions
            if ($e instanceof HttpException) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'An error occurred',
                    'error' => $e->getMessage(),
                ], $e->getStatusCode());
            }

            // Generic error response for API
            return response()->json([
                'message' => 'Server Error',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred',
            ], 500);
        }

        return parent::render($request, $e);
    }
}
