<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->isDev()) {
            // dd(Auth::User()->isDev());

            $components = ['user-list'];
        }
        if (Auth::user()->isAdmin()) {
            $components = ['project-list', 'projects-settings'];
        }
        if (Auth::User()->isUser()) {
            $components = ['project-list'];
        }
        $request->attributes->set('components', $components);

        return $next($request);
    }
}
