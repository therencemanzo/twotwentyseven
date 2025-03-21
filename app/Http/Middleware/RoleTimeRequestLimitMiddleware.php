<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleTimeRequestLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if the user has the "can edit articles" role
        if (!Auth::user()->hasRole('can-edit-articles')) {
            return response()->json(['error' => 'Forbidden: You do not have the required role'], 403);
        }

        // Check if the current time is between 9 AM and 5 PM
        $currentHour = now()->hour;

        if ($currentHour <= 9 || $currentHour >= 17) {
            return response()->json(['error' => 'Access denied: Available only between 9 AM and 5 PM'], 403);
        }

        // Track the number of requests from the user
        $request->user()->increment('request_count');


        return $next($request);
    }
}
