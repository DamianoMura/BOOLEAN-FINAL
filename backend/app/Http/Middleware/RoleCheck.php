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
            $request->merge($components);
            // dd($request->query);
        }
        if (Auth::user()->isAdmin()) {
            $components = ['project-list', 'available-users'];
            $request->merge($components);
        }
        if (Auth::User()->isUser()) {
            // dd(Auth::User()->isUser());
        }

        return $next($request);
    }
}
