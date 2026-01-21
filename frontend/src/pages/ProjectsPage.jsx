import React, { useState, useEffect } from 'react';
import { useFilters } from '../context/FiltersContext';
import Filters from './components/projects/Filters';

import axios from 'axios';

const ProjectsPage = () => {
  const { filters } = useFilters(); // filters from context
  const [projects,setProjects]=useState([]);
  const [loadingProjects,setLoadingProjects]=useState();

  // Fetch categories



  return (
    <div className="container py-4">
      
      
      <Filters
       
      />
      
    
    </div>
  );
};

export default ProjectsPage