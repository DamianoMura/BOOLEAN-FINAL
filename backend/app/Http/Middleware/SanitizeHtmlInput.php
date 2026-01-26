<?php

// app/Http/Middleware/SanitizeHtmlInput.php
namespace App\Http\Middleware;

use Closure;
use App\Services\HtmlSanitizer;

class SanitizeHtmlInput
{
    protected $sanitizer;

    public function __construct(HtmlSanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function handle($request, Closure $next)
    {
        // Sanitizza solo campi specifici
        if ($request->has('content') || $request->has('description')) {
            $input = $request->all();

            foreach (['content', 'description', 'body', 'html_content'] as $field) {
                if (isset($input[$field])) {
                    $input[$field] = $this->sanitizer->sanitize($input[$field]);
                }
            }

            $request->merge($input);
        }

        return $next($request);
    }
}
