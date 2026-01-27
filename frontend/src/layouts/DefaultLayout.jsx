import { Outlet } from "react-router-dom";
import Navbar from "./components/Navbar";
import Breadcrumbs from "./components/Breadcrumbs";


import React, { useContext } from 'react'; // ← AGGIUNGI useContext
import { FiltersContext } from '../context/FiltersContext';
const DefaultLayout = () => {

  return (
    <div class="relative w-100">
			<div className="top-0 bg-white shadow-md sticky-nav">
        <Navbar />
      <Breadcrumbs/>
      </div>
   
			<main className="mx-auto mt-40 max-w-7x1" >
        <Outlet />
			</main>
			
		</div>
  )
}

export default DefaultLayout