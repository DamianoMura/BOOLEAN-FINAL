<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // create default dev user;
        $devCredentials = Config::get('defaultDevUser');
        $new = User::create([
            'name' => $devCredentials['name'],
            'email' => $devCredentials['email'],
            'password' => Hash::make($devCredentials['password']),
        ]);

        $new->assignRole('dev');
        $new->save;
    }
}
