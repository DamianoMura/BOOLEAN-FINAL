import React from 'react'

const Home = () => {
  return (
    
      <div className="p-5 bg-white rounded-lg shadow">
        <div className="row">
          
          <div className="col-100">
            <p>Welcome to my brand new website thought to be a documentation website for all the projects i created and that you can find in to my github account!</p>
            <p>Not only that, as stated in the page before this is my case study for the exam for <strong>600 hours Course on Full-Stack Web Developement with Boolean Careers </strong></p>
            <p>I decided to implement the native style of <strong>Laravel</strong> as that's what i use for the back-end/backoffice of this application </p>
            <h3>
              Let's start explaining how all of this works:
            </h3>

            <h4 className="text-center">The Backend with Laravel</h4>
            <ul className="gap-2 p-2 list-unstyled">
              <li >
                I decided to implement a Role system where each of one of the roles have particular permissions
              </li>
              <li>
                The whole app is focused on projects as a main model with various fields ( name, author, description )
                 has many relationships:
                <ul>
                  <li><strong>Categories</strong> - one to many (undefined, full-stack,front-end, back-end)</li>
                  <li><strong>Technologies</strong> - many to many (all the technologies i studied for)</li>        
                  <li><strong>Sections</strong> - one to many (each project can have multiple sections )</li>        
                  <li><strong>Editors</strong> - many to many (the creator can assign other users to add sections to their project )</li>        
                </ul>
              </li>
            </ul>
            <section className="p-2 ">
              <h4>The Roles System:</h4>
              <div className="h-full row">
                <div className="mb-2 col-12 col-md-6 col-lg-4">
                  <div className="p-3 m-2 shadow h-100 card">
                    <h5 className="p-2 mb-2 text-center border-bottom"><strong>"dev"</strong> - Developer</h5>
                  <p>
                    The dev role is what we would give to HR in a structured company and is responsible to manage the roles inside the app.
                  </p>
                  <p>This role can be created by an artisan command <strong>php artisan dev:create</strong> when we are first booting the application, and </p>
                  </div>
                </div>
                <div className="mb-2 col-12 col-md-6 col-lg-4">
                  <div className="p-3 m-2 shadow h-100 card">

                    <h5 className="p-2 mb-2 text-center border-bottom"><strong>"admin"</strong> -Administrator</h5>
                    <p>The Administrator is who can see all projects (published or not) but can only modify it's own and decide wether or not to assign Users as Editors to their own projects</p>
                  </div>
                </div>
                <div className="mb-2 col-12 col-lg-4">
                  <div className="p-3 m-2 shadow h-100 card">
                    <h5 className="p-2 mb-2 text-center border-bottom"><strong>"user"</strong> -Regular User</h5>

                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>

   
  )
}

export default Home