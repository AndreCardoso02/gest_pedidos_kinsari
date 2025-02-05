<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Solicitante
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) { // se não estiver autenticado
            return redirect()->route('login');
        }

        if (!Auth::user()->isSolicitante()) { // se não for solicitante
            return redirect()->route('dashboard')->with('error', 'Acesso negado: você não é um solicitante.');
        }

        return $next($request);
    }
}
