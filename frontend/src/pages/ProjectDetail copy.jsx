
import ProjectSnap from './components/projects/ProjectSnap';
import ProjectSection from './components/projects/ProjectSection';
import axios from 'axios';
import { useNavigate, useLocation } from "react-router-dom";
import React, { useState, useEffect, useCallback } from 'react';

const ProjectDetail = () => {
  const location =useLocation()
  const [project , setProject]= useState([])
  console.log(project.sections)
  console.log(project.sections[0].author)
  useEffect(()=>{
    axios.get(`http://localhost:8000/api${location.pathname}`).then((resp)=>{
      console.log
      setProject(resp.data.data);
    }).catch((err)=> {
      
     
    });
  },[]);
  return (
    <div className="p-5 bg-white rounded-lg shadow">
       
      
    </div>
  )
}

export default ProjectDetail