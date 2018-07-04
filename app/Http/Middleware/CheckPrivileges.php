<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPrivileges
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guard('api')->user()->privilege >= $role) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'No privileges to this resource.'
        ], 403);
    }
}