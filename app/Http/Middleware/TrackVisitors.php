<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;

class TrackVisitors
{
    public function handle($request, Closure $next)
    {
        Visitor::create([
             'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        
        return $next($request);
    }
}
