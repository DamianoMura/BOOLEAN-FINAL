
import ProjectSnap from './components/projects/ProjectSnap';
import ProjectSection from './components/projects/ProjectSection';
import axios from 'axios';
import { useNavigate, useLocation } from "react-router-dom";
import React, { useState, useEffect, useCallback } from 'react';

const ProjectDetail = () => {
  const location =useLocation()
  const [project , setProject]= useState([])
  const cooperators=[];

  useEffect(()=>{
    axios.get(`http://localhost:8000/api${location.pathname}`).then((resp)=>{
    
      setProject(resp.data.data);
    }).catch((err)=> {
      
     
    });
  },[]);
  return (
    
    <div className="p-5 bg-white rounded-lg shadow">
        {project && Object.keys(project).length > 0 ? (
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
  )
}

export default ProjectDetail