<?php

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Support\Logger;
use Closure;

class LoggerMiddleware implements MiddlewareInterface
{

    public function handle(Request $request, Closure $next): ?Response
    {
        $response = $next($request);

        if ($response instanceof Response) {
            Logger::logApi('info', [
                'endpoint' => $request->getUri(),
                'method' => $request->getMethod(),
                'status_code' => $response->statusCode,
                'response_time_ms' => $response->headers['X-Response-Time'] ?? 0,
            ]);
        }

        return $response;
    }
}