<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UpdateRole extends Controller
{
    public function update(Request $request)
    {
        // dd($request->user_id);
        $user = User::find($request->user_id);

        $user->role()->detach();
        $user->assignRole($request->role);
        $user->save();

        return redirect(route('dashboard'))->with('status', 'role updated successfully');
    }
}
