<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if ($request->user() && in_array($request->user()->role->name, $roles)) {
        return $next($request);
    }
        return response()->json(['message' => 'No tienes permiso para realizar esta acción'], 403);
    }
}
