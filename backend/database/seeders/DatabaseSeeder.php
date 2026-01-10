<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Role;
use Database\Seeders\FakeUsers as SeedersFakeUsers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Seeding roles...');
        DB::table('roles')->insert([
            ['name' => 'dev', 'label' => 'Developer'],
            ['name' => 'admin', 'label' => 'Administrator'],
            ['name' => 'user', 'label' => 'Basic User'],

        ]);

        // creation dev user (mandatory);
        $this->command->info('Creating dev account...');

        $name = $this->command->ask('Name', 'dev');
        $email = $this->command->ask('Email', 'dev@example.com');
        $password = $this->command->secret('Password (minimo 8 caratteri)');

        // Base validation for password
        if (strlen($password) < 8) {
            $this->command->error('The password must be at least 8 characters');
            return;
        }

        $dev = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->command->info("Account dev created: {$dev->email}");
        $dev->assignRole('dev');
        $dev->save;

        //asks if you want to populate with fake users+1 admin
        if ($this->command->confirm('would you like to generate fake accounts for debugging?', true)) {
            $this->call(SeedersFakeUsers::class);
            $this->command->info('Fake users have been generated!');
        }
    }
}
