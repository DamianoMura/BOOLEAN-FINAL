import ProjectSnap from './components/projects/ProjectSnap';
import ProjectSection from './components/projects/ProjectSection';
import React, { useState, useEffect, useCallback } from 'react';
import axios from 'axios';
const Home = () => {
  const [project , setProject]= useState([])
   useEffect(()=>{
    axios.get(`http://localhost:8000/api/projects/boolean-exam-final-project`).then((resp)=>{
    
      setProject(resp.data.data);
    }).catch((err)=> {
      
     
    });
  },[]);
  
  return (
    
      <div className="p-5 bg-white rounded-lg shadow">
        <div className="p-4">
          <h1 className="mb-4 text-3xl font-bold text-center">Welcome to the Project Showcase</h1>
        <p>As you would expect i am going to render The showcase for this portfolio, by taking the information from the API and displaying it in a structured way.</p>
        <p>Here we do our first axios call where we go and grab the project data.</p>
        </div>
        <div className="p-5 bg-white rounded-lg shadow">
        {project && Object.keys(project).length > 0 ? 
        (
          <>
            <ProjectSnap project={project}>
              {project.editors && project.editors.length > 0 && (
                <div className="pt-3 mt-3 d-flex ">
                  <h5 className='me-3'>Also worked on this project:</h5>
                  <ul className="list-unstyled d-flex ">
                    {project.editors.map((editor , index) => 
                      (<li key={index}><span >{editor}</span><span className="me-1"> {index < project.editors.length-1 ? ", "  :''}</span></li>) 
                      )
                    }
                  </ul>
                </div>
              )}
            </ProjectSnap>
    
          </>
    
        ) : (
          <div className='mb-3 w-100 h-100 d-flex flex-cols justify-content-center align-items-center'>
            <div className="spinner-border me-3" role="status">
              <span className="sr-only"></span>
            </div>
            <div>Loading...</div>
          </div>
        )}

      {project.sections && project.sections.length > 0 && (
        <>
          <h3 className="m-3 text-center">More details...</h3>
          <ul className="list-unstyled">
            {project.sections.map((section) => (
              <li key={section.id}><ProjectSection  section={section}/></li> 
              
            ))}
          </ul>
        </>
      )}
      
    </div>
        
      </div>

   
  )
}

export default Home