<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class DemoSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $session = $request->session();
        $demoDb = $session->get('demo_db');

        // If this session already has a DB assigned, check it still exists
        if ($demoDb && file_exists($demoDb)) {
            Config::set('database.connections.sqlite.database', $demoDb);
            app('db')->purge('sqlite');
            return $next($request);
        }

        // Create a new session-specific database copy
        $basePath = database_path('base.sqlite');

        if (!file_exists($basePath)) {
            abort(500, 'Base demo database not found. Run: php artisan demo:seed');
        }

        $sessionsDir = database_path('sessions');
        if (!is_dir($sessionsDir)) {
            mkdir($sessionsDir, 0755, true);
        }

        $sessionId = $session->getId();
        $dbPath = $sessionsDir . '/demo_' . $sessionId . '.sqlite';

        copy($basePath, $dbPath);

        $session->put('demo_db', $dbPath);

        Config::set('database.connections.sqlite.database', $dbPath);
        app('db')->purge('sqlite');

        return $next($request);
    }
}
