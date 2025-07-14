<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TransactionMiddleware
{
    /**
     * Handle an incoming request wrapped in a DB transaction.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return DB::transaction(function () use ($request, $next) {
            try {
                return $next($request);
            } catch (Throwable $e) {
                throw $e;
            }
        });
    }
}
