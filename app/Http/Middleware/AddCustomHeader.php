<?php

namespace App\Http\Middleware;

use Closure;

class AddCustomHeader
{
    public function handle($request, Closure $next)
    {
        // Add your custom header
        $request->headers->set('secrate_key', 'common-court-key');

        return $next($request);
    }
}