<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;


class DashboardController extends Controller
{
    public function deploy(Request $request)
    {

        $defaultUser = Config::get('defaultDevUser');
        if ($request->user()->isDev() && ($request->user()->email === $defaultUser['email'] || $request->user()->name === $defaultUser['name'])) {
            session()->put('default-user', $defaultUser);
            return redirect(route('profile.edit'));
        }
        return view('dashboard');
    }
}
