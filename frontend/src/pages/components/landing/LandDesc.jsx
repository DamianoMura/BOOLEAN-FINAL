import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faLaravel, faReact, faBootstrap , faCss3  } from '@fortawesome/free-brands-svg-icons';
import { Link } from "react-router-dom";
const LandDesc = () => {
  return (
    <>
      <h1 className="text-center text-primary">Welcome to my website!</h1>
      <p>This is my portfolio website where i will post all my projects. <br/>
      the Frontend part is developed in React.js <FontAwesomeIcon icon={faReact} /> and   bootstrap.css <FontAwesomeIcon icon={faBootstrap} /></p>
      <p>This application will interact with the backend where i will be using Laravel 12 <FontAwesomeIcon icon={faLaravel} /> and   Tailwind.css <FontAwesomeIcon icon={faCss3} />  </p>
      <p>This is the Final Project Subject that signs the end of the 600 hours course @ <strong>Boolean</strong>  as <strong>FullStack Web Developer</strong> :</p>
      <p>
       I included a role system where Devs can manage the roles, Admins can create Projects and assign other users to work in them
       </p>
       <p>
        Please feel free to have a look inside! (cv included) 
       </p>
       <div className="text-center">
        
        <Link to ="/home" className="mb-3 btn btn-outline-primary justify-self-center"> enter</Link>
       </div>
   </>
  )
}

export default LandDesc