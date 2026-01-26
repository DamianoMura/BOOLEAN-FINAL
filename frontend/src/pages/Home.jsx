import React from 'react'

const Home = () => {
  return (
    
      <div className="p-5 bg-white rounded-lg shadow">
        <section id="menu">
          <i className="fa-solid fa-list"></i>
          <ul className="home-menu">
            <li><a href="#intro">Welcome</a></li>
            <li><a href="#dashboard">The Dashboards</a></li>
            <li><a href="#roles-system">The Roles System</a></li>
            <li><a href="#projects">The Projects</a></li>
          </ul>
        </section>
        <div className="row">
          
          <div className="col-100">
           
            <section id="intro">
              <h1>Welcome to my portfolio</h1>
              <p>Welcome to my brand new website thought to be a documentation website for all the projects i created and that you can find in to my github account!</p>
            <p>Not only that, as stated in the page before this is my case study for the exam for <strong>600 hours Course on Full-Stack Web Developement with Boolean Careers </strong></p>
            <p>I decided to implement the native style of <strong>Laravel</strong> as that's what i use for the back-end/backoffice of this application </p>
            <h3>
              Let's start explaining how all of this works:
            </h3>

            <h4 className="text-center">The Backend with Laravel</h4>
       
            </section>
            <section id="roles-system" className="p-2 ">
              <h4>The Roles System:</h4>
                   
              <p >
                I decided to implement a Role system where each of one of the roles have particular permissions
              </p>
              
            
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
            <section id="dashboard" className="p-2 ">
              <h4>The Dashboards</h4>
              <p>
                every role has a dashboard where he can access what's permitted to them, in fact the DEV dashboard will have a control panel for the roles , where it prints a full list of users and you can manage their roles . The dev cannot create users, he can only manage them inside the app.
              </p>
              <p>
                the admins dashboard will print off a list of projects they have created or worked on (admins can be included in other projects by other admins who created them) , together with the main info about the projects they will have a button to create new projects and edit or delete the existent ones, with the assign editors button.
              </p>
              </section>
            <section id="projects" className="p-2 ">
              <h4>The Projects</h4>
              <p>
                The whole app is focused on projects as a main model with various fields ( name, author, description )
                 has many relationships:
                <ul>
                  <li><strong>Categories</strong> - one to many (undefined, full-stack,front-end, back-end)</li>
                  <li><strong>Technologies</strong> - many to many (all the technologies i studied for)</li>        
                  <li><strong>Sections</strong> - one to many (each project can have multiple sections )</li>        
                  <li><strong>Editors</strong> - many to many (the creator can assign other users to add sections to their project )</li>        
                </ul>
              </p>
              <p>
                as stated above each project can be created by Administrators and add a Title, a quick description
              </p>
              </section>
            <section id="front-end" className="p-2 ">
              <h4>The Front-End with React</h4>
              <p> The front-end is built with React and uses various hooks to manage state and effects. The main page displays a list of projects fetched from the backend, with filtering options available to the user.</p>
              <p> The application uses React Router for navigation and URL management, allowing users to filter projects based on various criteria.
              </p>
              <p>The filters have been used as part of a React context in which the state gets updated based on what we selected and aims to refresh the query string of our webpage, and as soon as we invoke the filters by using the buttons only (search and clear) to avoidan API call each time we add a character or change any of the dropdown options </p>
            </section>
           
          </div>
        </div>
      </div>

   
  )
}

export default Home