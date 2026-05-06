<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
* Class CheckPermission (Middleware)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This middleware checks whether the authenticated user has the required permission.
*/
class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!auth()->check() || !auth()->user()->hasPermission($permission)) {
            abort(403, 'No tienes permiso para acceder aquí.');
        }
        return $next($request);
    }
}
