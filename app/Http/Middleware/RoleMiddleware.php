<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$accepted_role)
    {
        $role = strtolower(Auth::user()->role);
        $accepted_role = array_map('strtolower', $accepted_role);
        if (!in_array($role, $accepted_role)) return abort(401);
        return $next($request);
    }
}
