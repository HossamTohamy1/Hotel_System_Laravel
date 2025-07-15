<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        //
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {

            // Validation error
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'status' => false,
                    'message' => $exception->validator->errors()->first(),
                ], 422);
            }

            // Custom business logic exception
            if ($exception instanceof BusinessLogicException) {
                return response()->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                ], 400);
            }

            // Not found (Model not found)
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => false,
                    'message' => 'The requested resource was not found.',
                ], 404);
            }

            // Unauthenticated
            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Authentication is required to access this resource.',
                ], 401);
            }

            // Unauthorized
            if ($exception instanceof AuthorizationException) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to access this resource.',
                ], 403);
            }

            // Query/database error
            // if ($exception instanceof QueryException) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => config('app.debug') ? $exception->getMessage() : 'A database error occurred.',
            //     ], 500);
            // }

            // // Fallback for other unexpected exceptions
            // return response()->json([
            //     'status' => false,
            //     'message' => config('app.debug') ? $exception->getMessage() : 'An unexpected error occurred.',
            // ], 500);
        }

        return parent::render($request, $exception);
    }
}
