<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        $entityId = $request->header('entity-id');
        if ($user->roles()->whereIn('id', $roles)->wherePivot('entity_id', $entityId)->exists()) {
            return $next($request);
        }

        return $next($request);
    }
}
