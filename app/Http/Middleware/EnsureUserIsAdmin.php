<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário autenticado tem o campo 'is_admin' como true
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        return response()->json(['error' => 'Acesso negado: Apenas administradores.'], 403);
    }
}
