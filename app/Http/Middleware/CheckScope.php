<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckScope
{
    public function handle($request, Closure $next, $scope)
    {
        if (!Auth::user() || !Auth::user()->tokenCan($scope)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}