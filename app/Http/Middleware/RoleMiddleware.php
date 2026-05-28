<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, $permission = null)
    {

        $roles = explode("|", $role);
        $authorize = false;
        foreach ($roles as $r){
            if($request->user()->hasRole($r))
                $authorize = true;
        }
        if(!$authorize)
            abort(404);

        if($permission != null && !$request->user()->can($permission)){
            abort(404);
        }

        return $next($request);
    }
}
