<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class DashboardController extends Controller
{

    public function deploy(Request $request)
    {
        $components = $request->attributes->get('components');
        // dd($components);
        return view('auth.dashboard', ['components' => $components]);
    }
}
