<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRolDelUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = auth()->user();

        if($currentUser->is_admin) return $next($request);

        return redirect()
            ->route('auth.formLogin')
            ->with('status.type', 'error')
            ->with('status.message', 'No tenés permisos para ver está sección.');
    }
}
