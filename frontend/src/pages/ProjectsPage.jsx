import React, { useState, useEffect, useCallback } from 'react';
import { useNavigate, useLocation } from "react-router-dom";
import { useFilters } from '../context/FiltersContext';
import Filters from './components/projects/Filters';

import axios from 'axios';

const ProjectsPage = () => {
  const navigate = useNavigate();
  const { filters } = useFilters(); // filters from context
  const [projects,setProjects]=useState([]);//state for projects
  const [loadingProjects,setLoadingProjects]=useState(); //loading state from axios call

// we make a db call with location.search as string query
	  useEffect(()=>{
    axios.get(`http://localhost:8000/api/projects`).then((resp)=>{
      
      setProjects(resp.data.data);
    }).catch((err) => navigate("/not-found", {replace : true}));
  },[])
  useEffect(()=>{
		const qS = new URLSearchParams();
      const currentFilters=Object.entries(filters)
      console.log(currentFilters)
      currentFilters.map((query)=>{
        qS.set(query[0],query[1])
      })
			navigate({ search: qS.toString() }, { replace: true });
	},[filters])



  return (
    <div className="p-5 bg-white rounded-lg shadow">
      
      
      <Filters />
      
    
    </div>
  );
};

export default ProjectsPage