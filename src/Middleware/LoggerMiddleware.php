<?php

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;

class LoggerMiddleware implements MiddlewareInterface
{

    public function handle(Request $request, Closure $next): ?Response
    {
        // Log the incoming request
        error_log("Incoming request: " . $request->getMethod() . " " . $request->getUri());

        // Proceed to the next middleware or controller
        $response = $next($request);

        // Log the outgoing response
        if ($response instanceof Response) {
            error_log("Outgoing response: " . json_encode(obj2array($response)));
        }

        return $response;
    }
}