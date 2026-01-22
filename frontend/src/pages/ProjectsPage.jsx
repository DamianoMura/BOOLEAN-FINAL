import React, { useState, useEffect, useCallback } from 'react';
import { useNavigate, useLocation } from "react-router-dom";
import { useFilters } from '../context/FiltersContext';
import Filters from './components/projects/Filters';

import ProjectSnap from './components/projects/ProjectSnap';

import axios from 'axios';

const ProjectsPage = () => {
  const navigate = useNavigate();
  const location=useLocation();
  
  const  {filters, resetFilters}  = useFilters(); // filters from context
  const [projects,setProjects]=useState([]);//state for projects
  const [loadingProjects,setLoadingProjects]=useState(); //loading state from axios call

// we make a db call with location.search as string query
	  useEffect(()=>{
    axios.get(`http://localhost:8000/api/projects${location.search}`).then((resp)=>{
      
      setProjects(resp.data.data);
    }).catch((err)=> {
      
      alert(`Bad filter \n${err.message} \nReturning all projects as we reset the filters`);
      
      
      resetFilters([]);
     
      replaceSearchValue();
      
      
      // Reset dell'URL (opzionale)
      navigate({ search: '' }, { replace: true });
    });
  },[location.search]);
  const replaceSearchValue = useCallback(() => {
  const searchInput = document.getElementById('search');
  if (searchInput) {
    searchInput.value = '';
    // Trigger event per aggiornare eventuali stati collegati
    searchInput.dispatchEvent(new Event('input', { bubbles: true }));
    searchInput.dispatchEvent(new Event('change', { bubbles: true }));
  }
}, []);
  //refresh query string
  useEffect(()=>{
		const qS = new URLSearchParams();
      const currentFilters=Object.entries(filters)
      
      currentFilters.map((query)=>{
      
            qS.set(query[0], query[1]);
       
      })
			navigate({ search: qS.toString() }, { replace: true });
	},[filters])



  return (
    <div className="p-5 bg-white rounded-lg shadow">
      
      
      <Filters />
        
      <ul className='list-unstyled'>
        {projects.lenght === 0 ? (
          <li id="loading">loading...</li>
        ) :
        (
          projects.map((project)=>(
            <li  key={project.id} className='my-2'>
              <ProjectSnap project={project}/>
            </li>

          ))
        )}
      </ul>
    
    </div>
  );
};

export default ProjectsPage