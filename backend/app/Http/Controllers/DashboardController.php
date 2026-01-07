<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;


class DashboardController extends Controller
{
    public function deploy(Request $request)
    {
        if ($request->user()->email === Config::get('defaultDevUser')['email'])
            return redirect()->intended(route('dev-reset', absolute: false));
        else
            return view('dashboard');
    }
}
