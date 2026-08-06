<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log POST, PUT, DELETE, PATCH requests
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            // Filter sensitive keys
            $payload = $request->except(['password', 'password_confirmation', '_token']);
            
            $activity = $request->method() . ' ' . $request->path();
            $description = 'Request payload: ' . json_encode($payload);

            // Log activity
            ActivityLog::log($activity, $description);
        }

        return $response;
    }
}
