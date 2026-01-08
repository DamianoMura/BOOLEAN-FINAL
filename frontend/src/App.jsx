import React from 'react'
import './App.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
//router-dom imports
import { BrowserRouter, Routes, Route } from "react-router-dom";

// pages
import HomePage from "./pages/HomePage";

//layouts


const App = () => {
  return (
    <BrowserRouter>
    <Routes>
{/* route della landing page senza layout */}
      <Route> 
        <Route path="/" element={<HomePage />} />
      </Route>
    </Routes>
    </BrowserRouter>
  )
}

export default App