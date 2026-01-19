<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Models\Project;
use App\Models\ProjectSection;

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
        $error = false;
        $uri = explode('/', $request->Uri()->path());
        if (reset($uri) == 'projects' && (end($uri) === 'edit' || end($uri) === 'delete'  || end($uri) === 'store' || end($uri) === 'manageEditors')) {
            $project = Project::where('slug', $uri[1])->first();


            if ($project->author_id != Auth::id()) {
                $error = true;
            }
        } else if (reset($uri) == 'projects' && end($uri) === 'create') {
            if (Auth::user()->isAdmin() === false) {

                $error = true;
            }
        }



        if ($error) throw new AuthorizationException;


        return $next($request);
    }
}
