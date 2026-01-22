import {React  , useState} from 'react'

import { Link  , useLocation } from "react-router-dom";

const Breadcrumbs = () => {
  //location for breadcrumbs
  const location = useLocation();
  
  const pathnames = location.pathname.split('/').filter(x => x);
    const pathMap = {
    'home': 'Welcome Aboard!',
    'projects': 'Projects',
    
    };
    const formatName = (path) => {
    const mapped = pathMap[path];
    if (mapped) return mapped;
    
    return path
      .replace(/-/g, ' ')
      .replace(/_/g, ' ')
      .split(' ')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join(' ');
  };
  return (
    <>
    <div className="mx-auto bg-white">
      {pathnames.map((names)=>(
        <div>{names} </div>

      ))}
    </div>
    </>
  )
}

export default Breadcrumbs