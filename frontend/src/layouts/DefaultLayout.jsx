import { Outlet } from "react-router-dom";
import Navbar from "./components/Navbar";

import Breadcrumbs from "./components/Breadcrumbs";


import React, { useContext } from 'react'; // ← AGGIUNGI useContext
import { FiltersContext } from '../context/FiltersContext';
const DefaultLayout = () => {
   
  return (
    <div>
			<Navbar />
      <Breadcrumbs/>
			<main className="mx-auto mt-40  max-w-7x1" >
        <Outlet />
			</main>
			
		</div>
  )
}

export default DefaultLayout