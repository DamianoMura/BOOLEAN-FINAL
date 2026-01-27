<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectSection;

class FakeProject extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project_1 = Project::create([
            'title' => 'boolean exam final project',
            'slug' => 'boolean-exam-final-project',
            'category_id' => 4,
            'github_url' => 'https://github.com/DamianoMura/BOOLEAN-FINAL',
            'author_id' => 4,
            'description' => 'This is the project subject for the exam at boolean for Web Developement (600 hours)',
            'published' => true

        ]);
        // adding project sections to the boolean exam final project
        $projectSection_1 = ProjectSection::create([
            'title' => 'Introduction',
            'content' => '<p> The Final Project wanted from us to create two different apps for the front(React.js) and the backend/backoffice(Laravel) </p> <p>The aim of this final project is to demonstrate our ability on manage Models through <strong>Laravel</strong>, and put them in relation between them using all of them : <ul><li>One to One</li><li>One to Many</li><li>Many to Many</li></ul></p><p>Another ability to be verified is to write the <strong>API\'s</strong> and be able to use the json response in the front end</p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_2 = ProjectSection::create([
            'title' => 'The Backend with Laravel',
            'content' => '<p>As we stated before we coded our backend with laravel which has the backoffice feature, so we will have different Roles and different actions we can perform</p> <p>In the next section we will dive into whaat the roles are</p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_3 = ProjectSection::create([
            'title' => 'The Roles',
            'content' => '<p>We now dive into our first Model that we put in relation <strong>Many to Many</strong></p><p>i thought out to have a structured workflow like in a Company so here\'s the three Roles available: <ul><li><strong>"dev"</strong> which functions as the HR, and manages the roles of the registered accounts</li><li><strong>"admin"</strong> is the "Content Creator" number one, he can create projects, edit them and add sections like this one you are reading now. he can also add users as editors</li><li><strong>"user"</strong> is the lowest level Role for this application and he can only add sections waiting for admins to publish them</li></ul></p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_4 = ProjectSection::create([
            'title' => 'The Role based Dashboard',
            'content' => '<p>Every user will have a personalised dashboard based on their role</p><p>All this is managed by a <strong>middleware</strong> that goes and checks the role and adds to the request, an attribute array with the names of the components that are meant to be rendered</p><p>in the future there will be multiple components so I implemented the rendering through a accordion by tab in Alpine.js and foreach element in that array, it will render a dynamic component</p><p><strong>ps. i left an empty component in dev dashboard to show how it works</strong></p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_5 = ProjectSection::create([
            'title' => 'The Projects',
            'content' => '<p>As the Main <strong>model</strong> we have the Projects themselves where we have different fields: <ul><li>title</li><li>author_id</li><li>description</li></ul></p><p>All together with the projects we also have some more models put in relation to the Project Model: <ul><li><strong>Technologies</strong> that are in a relation Many to Many</li><li><strong>Categories</strong> in relation One to Many</li><li><strong>ProjectSections</strong>(the one you are reading from) in relation Many to Many </li></ul></p><p>Each project can be created as draft or published directly, but the same don\'t go for the sections as they are stored as draft by default</p><p>The process of creation of a project is done by the Admins that can create a project and assign technologies and categories, then they can add sections to it or assign editors to add sections</p><p>While browsing the full list we have a filter menu that allows us to search through projects by typing anithing included in the title or description, filter by category or technology and decide the sorting by date either ascendent or descendent.</p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_6 = ProjectSection::create([
            'title' => 'Adding Editors',
            'content' => '<p>I implemented a portion of the project-snap, which would be the main part without sections, where the Admins will have a summary of the editors assigned that when hovered shows who the editors are and next to it a button that will show a modal in which we can select or deselect users as editors from a full list</p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_7 = ProjectSection::create([
            'title' => 'The Sections',
            'content' => '<p>The Sections are the content pieces that go to form the project page</p><p>Each section has a title and a content field that is managed through a middleware and a helper(cast)<strong>SanitizeHtmlinput</strong> and <strong>HtmlCasts</strong>  that allows to write HTML content </p><p>Each section is created as draft by default and needs to be published by an Admin to be visible in the project page or in the React application for guests</p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_8 = ProjectSection::create([
            'title' => 'The API',
            'content' => '<p>The <strong>API</strong> uses a separate controller that handles the requests from the React application</p><p>We have different endpoints that return the list of published projects with their relations(technologies, categories and sections) and a single project by slug with all its relations</p><p>The Index has a filtering system that allows to filter projects by technology or category through query params like in the backoffice</p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_9 = ProjectSection::create([
            'title' => 'The Frontend with React.js',
            'content' => '<p>The front end is been engineered in a way to reflect the same style as the front end of the backoffice, with Laravel\'s minimalist layout and style</p><p>It is been real challenging as in the Laravel project i used Tailwind and in the React project i used Bootstrap (cheating a bit with custom css classes)</p><p>As you would expect there are more controls for the Admins to fiddle with, and are the edit delete buttons, and decide the position of the sections by simply moving up or down with the buttons available on the right.</p><p>Let\'s not forget the interactive publish/draft button </p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
            'published' => true
        ]);
        $projectSection_10 = ProjectSection::create([
            'title' => 'The Frontend - AJAX calls',
            'content' => '<p>we find the first AJAX call in the home route, in fact it will have to show this very project that describes the website you are currently visiting</p><p>I used  <strong>Axios</strong> (as it is what we have used throughout the main course) to perform AJAX calls to the Laravel API we created before</p><p>We have two main pages: <ul><li>The Projects List that shows all the published projects with a filtering system similar to the backoffice one</li><li>The Project Page that shows the single project with all its sections rendered as HTML</li></ul></p><p>Both pages are responsive and mobile friendly developed with the philosophy mobile-first</p>',
            'project_id' => $project_1->id,
            'user_id' => 4,
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
        $project_1->editor()->attach($project_1->author_id);
        $project_2->technology()->attach([8, 3, 5]);
        $project_2->editor()->attach($project_2->author_id);
    }
}
