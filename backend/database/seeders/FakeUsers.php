<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FakeUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $new = User::create([
            'name' => 'User_1',
            'email' => 'user_1@fake.it',
            'password' => Hash::make('password'),
        ]);

        $new->assignRole('user');
        $new->save;
        $new_1 = User::create([
            'name' => 'User_2',
            'email' => 'user_2@fake.it',
            'password' => Hash::make('password'),
        ]);

        $new_1->assignRole('user');
        $new_1->save;
        $new_2 = User::create([
            'name' => 'User_3',
            'email' => 'user_3@fake.it',
            'password' => Hash::make('password'),
        ]);

        $new_2->assignRole('user');
        $new_2->save;
        $new_3 = User::create([
            'name' => 'Damiano Mura',
            'email' => 'Admin@fake.it',
            'password' => Hash::make('password'),
        ]);

        $new_3->assignRole('admin');
        $new_3->save;
    }
}
