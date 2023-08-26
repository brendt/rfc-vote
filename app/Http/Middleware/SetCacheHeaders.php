<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class SetCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $seconds): Response
    {
        $response = $next($request);

        $cacheControl = [
            "max-age=$seconds",
            "s-maxage=$seconds",
            "stale-while-revalidate=$seconds",
            "stale-if-error=$seconds",
        ];

        $response->headers->set('Cache-Control', 'public, ' . Arr::join($cacheControl, ", "));
        $response->headers->set('Expires', now()->addSeconds($seconds)->toRfc7231String());

        return $response;
    }
}
