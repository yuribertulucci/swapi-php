<?php

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;

interface MiddlewareInterface
{
    public function handle(Request $request, Closure $next): ?Response;
}