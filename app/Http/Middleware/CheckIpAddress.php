<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIpAddress
{
    protected $allowedIps = [
        '127.0.0.1', // IPv4 localhost
        '::1',       // IPv6 localhost
        // Add your allowed IPs here
    ];

    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->ip(), $this->allowedIps)) {
            \Log::warning('Blocked IP attempt: ' . $request->ip());
            return response()->view('errors.ip_blocked');
        }

        return $next($request);
    }
}
