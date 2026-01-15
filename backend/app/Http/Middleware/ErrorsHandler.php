<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorsHandler
{
    public $message;
    public $status;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $this->status = $response->status();
        // dd($request);
        $handledErrors = [401, 402, 403, 404, 419, 429, 500, 503];

        if (in_array($this->status, $handledErrors)) {
            $errorMessages = [
                401 => 'Unauthorized - Please login to access this page.',
                402 => 'Payment Required - Subscription needed.',
                403 => 'Forbidden - You don\'t have permission.',
                404 => 'Page Not Found - The requested page doesn\'t exist.',
                419 => 'Page Expired - Please refresh and try again.',
                429 => 'Too Many Requests - Please slow down.',
                500 => 'Server Error - Something went wrong on our end.',
                503 => 'Service Unavailable - We\'re temporarily down for maintenance.',
            ];

            $this->message = $errorMessages[$this->status] ?? 'An error occurred.';

            // Restituisci la view con dati
            return response()->view('error', [
                'status' => $this->status,
                'message' => $this->message,

            ]);
        }
        return $response;
    }
}
