<?php

namespace App\Http\Middleware;

use app\models\rbac\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = \Auth::user();

        if (!$user) {
            return abort(401, 'Unauthorized');
        }

        if($user->isAdmin()){
            return $next($request);
        }
        return  abort(404, 'Not found');
    }

    
}

