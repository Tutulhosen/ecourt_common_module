<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GccRouteProtectSecond
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $roles=array(1,2,3);
        $userData = Auth::user();

        $currentrole=Auth::user()->citizen_type_id;
        if (in_array($currentrole, $roles))
        {
            return $next($request);
        }
        else
        {
            
            return response()->json('Sorry return back');
        }
    }
}
