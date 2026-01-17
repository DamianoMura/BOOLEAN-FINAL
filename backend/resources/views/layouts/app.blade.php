<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Thi is the backoffice of www.jdwdev.it which is the personal portfolio belonging to Damiano Mura">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
            integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/assets/favicon.ico') }}">
        <script>
            // Trusted Types configuration per Alpine.js
        (function() {
            if (!window.trustedTypes || !trustedTypes.createPolicy) {
                return; // Trusted Types non supportato
            }
            
            try {
                // Crea policy specifica per Alpine
                const alpinePolicy = trustedTypes.createPolicy('alpine-eval', {
                    createScript: function(script) {
                        // Controlli di sicurezza
                        const dangerousPatterns = [
                            /document\./,
                            /window\./,
                            /eval\(/,
                            /Function\(/,
                            /\.innerHTML/,
                            /\.outerHTML/
                        ];
                        
                        // Verifica che lo script non contenga pattern pericolosi
                        for (const pattern of dangerousPatterns) {
                            if (pattern.test(script)) {
                                console.warn('Potentially dangerous script blocked by Trusted Types:', script.substring(0, 100));
                                throw new Error('Script contains dangerous patterns');
                            }
                        }
                        
                        return script;
                    },
                    createScriptURL: function(url) {
                        // Permetti solo URL sicuri
                        const allowedDomains = [
                            window.location.origin,
                            'https://cdn.jsdelivr.net',
                            'https://unpkg.com'
                        ];
                        
                        try {
                            const parsedUrl = new URL(url, window.location.href);
                            if (allowedDomains.some(domain => parsedUrl.origin === domain)) {
                                return url;
                            }
                        } catch (e) {
                            // URL non valido
                        }
                        
                        return 'about:blank';
                    }
                });
                
                // Usa questa policy per Alpine
                window.alpineTT = alpinePolicy;
                
            } catch (error) {
                console.error('Failed to create Trusted Types policy for Alpine:', error);
            }
        })();
        </script>
        
        <!-- Poi carica Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="flex flex-col justify-between px-4 py-6 mx-auto space-y-2 max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                        <x-auth-session-status :status="session('status')">
                        </x-auth-session-status>
                    </div>
                    
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex flex-col px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    </body>
</html>
