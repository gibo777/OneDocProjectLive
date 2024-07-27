<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckServerStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $userIdToExclude = 1; // User ID to exclude from server status check

        // Check if the current user is authenticated and is not excluded
        if (Auth::check() && Auth::id() != $userIdToExclude) {
            // Retrieve server status from database
            $serverStatus = DB::table('server_status')->where('id', 1)->value('status');

            // Check if server status indicates it is down (0)
            if ($serverStatus == 0) {
                return response()->view('errors.503', [], 503); // Custom view for server down
            }
        }

        return $next($request);
    }
}
