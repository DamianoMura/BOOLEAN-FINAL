<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Role;

class DashboardController extends Controller
{

    public function deploy(Request $request)
    {

        $defaultUser = Config::get('defaultDevUser');
        if ($request->user()->isDev() && ($request->user()->email === $defaultUser['email'] || $request->user()->name === $defaultUser['name'])) {
            session()->put('default-user', $defaultUser);
            return redirect(route('profile.edit'));
        }

        if ($request->user()->isDev()) {
            $users = User::all();
            $devs = Role::where('name', 'dev')->first()->user()->count();
            $admins = Role::where('name', 'admin')->first()->user()->count();
            // dd($devs);
            $roles = Role::all();
            return view('auth.dev', ['users' => $users, 'roles' => $roles, 'devs' => $devs, 'admins' => $admins],);
        }
        if ($request->user()->isAdmin()) {
            return view('auth.admin');
        }
        if ($request->user()->isUser()) {
            return view('auth.user');
        }
    }
}
