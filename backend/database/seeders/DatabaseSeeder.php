<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RoleSeeder::class);
        User::create([
            'name' => 'Demianz',
            'email' => 'demianz@jdwdev.it',
            'password' => bcrypt('asdasdasd'),
        ]);
        User::first()->roles()->attach(Role::where('name', 'admin')->first());
    }
}
