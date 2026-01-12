<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class FakeProject extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project_1 = Project::create([
            'title' => 'Lorem ipsium dolor',
            'slug' => 'lorem-ipsium-dolor',
            'category_id' => 3,
            'author_id' => 4,
            'description' => 'questo è un progetto creato dal seeder fatto per debugging',
            'published' => true

        ]);
        $project_2 = Project::create([
            'title' => 'Lorem test 2',
            'slug' => 'lorem-test-2',
            'category_id' => 1,
            'author_id' => 4,
            'description' => 'questo è un progetto creato dal seeder fatto per debugging'

        ]);

        //fittitious technologies
        $project_1->technology()->attach([1, 3, 5]);
        $project_2->technology()->attach([8, 3, 5]);
    }
}
