<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the demo user selection view.
     */
    public function create(): View
    {
        $demoUsers = User::whereHas('role', function ($query) {
            $query->where('name', '!=', 'dev');
        })->get();

        return view('auth.login', compact('demoUsers'));
    }

    /**
     * Log in as the selected demo user.
     */
    public function store(LoginRequest $request)
    {
        $user = User::findOrFail($request->input('demo_user'));

        if ($user->isDev()) {
            return back()->withErrors(['demo_user' => 'This user is not available in demo mode.']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session and clean up the session database.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $demoDb = $request->session()->get('demo_db');
        if ($demoDb && file_exists($demoDb)) {
            app('db')->purge('sqlite');
            @unlink($demoDb);
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
