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
  const [loadingProjects,setLoadingProjects]=useState(true); //loading state from axios call
  const [paginationInfo,setPaginationInfo]=useState({});//pagination state from axios call
  const [paginationLinks,setPaginationLinks]=useState({});//pagination LINKS from axios call
// we make a db call with location.search as string query
	  useEffect(()=>{
    axios.get(`http://localhost:8000/api/projects${location.search}`).then((resp)=>{
      
      setLoadingProjects(false)
      setPaginationInfo(resp.data.meta);
      setPaginationLinks(resp.data.links);
      setProjects(resp.data.data);
    }).catch((err)=> {
        alert(`->${err.message} \n Please try reloading the page.`);
        resetFilters([]);
        replaceSearchValue();
        navigate({ search: '' }, { replace: true });
    });
  },[location.search]);
//use effect reloads when location.search changes

  const replaceSearchValue = useCallback(() => {
  const searchInput = document.getElementById('search');
  if (searchInput) {
    searchInput.value = '';
    
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
        {projects && Object.keys(projects).length > 0 ? (
          projects.map((project)=>(
            <li  key={project.id} className='my-2'>
              <ProjectSnap project={project}/>
            </li>

          ))
        ) :
        (
           loadingProjects==true ?

         ( <div className='mt-100 w-100 h-100 d-flex flex-cols justify-content-center align-items-center'>
            <div className="spinner-border me-3" role="status">
              <span className="sr-only"></span>
            </div>
            <div>Loading...</div>
          </div>)
          :(
          <div className='mt-100 w-100 h-100 d-flex flex-cols justify-content-center align-items-center'>
            
            <div>No Projects found...</div>
          </div>)
          
          
        )}
      </ul>
        <div className="mt-4 w-100 d-flex justify-content-between align-items-center">
          <i className={`fa-solid fa-caret-left fs-1 mx-3 ${paginationLinks.prev ? 'clickable' : 'hidden'}`}
            onClick={() => {
              if (paginationLinks.prev) {
                navigate({ search: paginationLinks.prev.split('?')[1] }, { replace: true });
              }
            }}></i>
          <div>Page {paginationInfo.current_page} of {paginationInfo.last_page}</div>
          <i className={`fa-solid fa-caret-right fs-1 mx-3 ${paginationLinks.next ? 'clickable' : 'hidden'}`}
            onClick={() => {
              if (paginationLinks.next) {
                navigate({ search: paginationLinks.next.split('?')[1] }, { replace: true });
              }
            }}></i>
        </div>
    </div>
  );
};

export default ProjectsPage