import {React  , useState} from 'react'

import { Link  , useLocation } from "react-router-dom";

const Breadcrumbs = () => {
  //location for breadcrumbs
  const location = useLocation();
  
  const pathnames = location.pathname.split('/')
  pathnames.shift()
  
  return (
    <>
    <div className="py-4 bg-white d-flex">
      <div className="container ">
        <ul className="my-auto d-flex list-unstyled align-items-center">
          {pathnames.map((name) => {
        
            if (location.pathname.startsWith(`/${name}`) && pathnames.length>1) {
              return (
                <li key={name} className="d-flex fw-semibold align-items-center bread-link">
                  <i className="fa-solid fa-chevron-right"></i>
                  <Link to={`/${name}`} className="text-black text-decoration-none -transform-y-2">  {name}</Link>
                </li>
              ) ;
            } else {
              return <li key={name} className="d-flex align-items-center">
                  <i className="fa-solid fa-chevron-right lh-2 "></i>
                  <div className='-transform-y-2'>  {name}</div>
                </li>;
            }
            })
          }

        </ul>
      </div>
    </div>
    </>
  )
}

export default Breadcrumbs