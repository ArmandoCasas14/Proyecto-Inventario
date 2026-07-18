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
        // 1. Verificar si el usuario está autenticado
        if (!$request->user()) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'No autenticado'], 401);
            }
            return redirect()->route('login');
        }

        // 2. Si es Administrador, le damos superpoderes (acceso total siempre)
        // Ajusta 'Administrador' según cómo esté escrito exactamente en tu tabla de roles
        if ($request->user()->role->name === 'Administrador') {
            return $next($request);
        }

        // 3. Verificar si el rol del usuario coincide con los requeridos por la ruta
        if (in_array($request->user()->role->name, $roles)) {
            return $next($request);
        }

        // 4. Si no tiene permisos, adaptamos la respuesta según el origen
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'No tienes permiso para realizar esta acción'], 403);
        }

        // Para las vistas web, disparamos el error 403 nativo de Laravel
        abort(403, 'No tienes permiso para realizar esta acción.');
    }
}