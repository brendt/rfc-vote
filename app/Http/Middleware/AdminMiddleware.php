<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user?->is_admin) {
            return response()->redirectTo('/');
        }

        return $next($request);
    }
}
