<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Project;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //assign attributes for dashboard
        if (Auth::user()->isDev()) {
            $components = ['user-list'];
        }
        if (Auth::user()->isAdmin()) {
            $components = ['project-list', 'projects-settings'];
        }
        if (Auth::User()->isUser()) {
            $components = ['project-list'];
        }
        $request->attributes->set('components', $components);


        //checking if you are trying to access routes you are not supposed to access in the /projects route

        $uri = explode('/', $request->Uri()->path());
        if (reset($uri) == 'projects' && (end($uri) === 'edit' || end($uri) === 'delete' || end($uri) === 'create' || end($uri) === 'store')) {
            $project = Project::where('slug', $uri[1])->with(['editor'])->first();
            if ($project->editor->contains('user_id', Auth::id()) === false) {
                return back()->with('status', 'You can\'t perform this action');
            }
        }


        return $next($request);
    }
}
