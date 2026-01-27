<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Role;
use Database\Seeders\FakeUsers as SeedersFakeUsers;
use Database\Seeders\FakeProject as SeedersFakeProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Project;


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
        $this->command->info('Seeding technologies...');
        $techList = config('tech-list');
        foreach ($techList as $tech) {
            DB::table('technologies')->insert(
                [
                    'name' => $tech['name'],
                    'label' => $tech['label'],
                    'fontawesome_class' => $tech['fontawesome-class']
                ]
            );
        }
        $this->command->info('Seeding Categories...');


        DB::table('categories')->insert([
            [
                'name' => 'NDC',
                'label' => 'Undefined Category',
            ],
            [
                'name' => 'front-end',
                'label' => 'Front End',
            ],
            [
                'name' => 'back-end',
                'label' => 'Back End',
            ],
            [
                'name' => 'full-stack',
                'label' => 'Full Stack',
            ]
        ]);






        //asks if you want to populate with 3 fake users +1 admin
        if ($this->command->confirm('would you like to generate fake accounts for debugging?', true)) {
            $this->call(SeedersFakeUsers::class);
            $this->command->info('Fake users have been generated!');
        }
        //asks if you want to populate with 2 fake projects
        if ($this->command->confirm('would you like to generate fake projects for debugging?', true)) {
            $this->call(SeedersFakeProject::class);
            $this->command->info('Fake projects have been generated!');
        }

        $this->command->info('make sure you run the command "php artisan dev:create" to create the first dev or you won\'t be able to use all the functionalities and the website will be empty');
    }
}
