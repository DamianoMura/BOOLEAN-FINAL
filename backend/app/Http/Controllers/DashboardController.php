<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;


class DashboardController extends Controller
{

    public function deploy(Request $request)
    {
        $components = $request->attributes->get('components');
        // dd($components);
        return view('auth.dashboard', ['components' => $components]);
    }
}
