<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$tipo_usuario): Response
    {
        if (!auth()->check()) {
            // Usuario no autenticado
            return redirect('/');
        }

        $usuario = auth()->user();

        $usuario_tipo = $usuario->tipo_usuario->nombre;
        
        // Verificar si el usuario tiene al menos uno de los roles especificados
        if (in_array($usuario_tipo, $tipo_usuario)) {
            return $next($request);
        }

        session()->flash('status', 'Acceso no autorizado');
        session()->flash('icon', 'error');
        return to_route('inicio');
    }
}
