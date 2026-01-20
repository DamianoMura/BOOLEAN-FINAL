import {React  , useState} from 'react'

import { Link  , useLocation } from "react-router-dom";
import * as Dom  from 'react-bootstrap';
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
    <Dom.Breadcrumb className="p-3 bg-white shadow">
        {pathnames.map((name, index) => {
        const routeTo = `/${pathnames.slice(0, index + 1).join('/')}`;
        const isLast = index === pathnames.length - 1;
        
        return  (
          <Dom.Breadcrumb.Item active key={routeTo} className="text-center w-100">
           <h1 > {formatName(name)}</h1>
          </Dom.Breadcrumb.Item>
        ) 
      })}
      </Dom.Breadcrumb>
  )
}

export default Breadcrumbs