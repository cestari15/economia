<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário autenticado é admin
        if ($request->user() && $request->user()->tipo === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Acesso negado.'], 403);
    }
}