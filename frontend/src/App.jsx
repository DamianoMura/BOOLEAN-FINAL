import React from 'react'
import './App.css'
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
//router-dom imports
import { BrowserRouter, Routes, Route } from "react-router-dom";

// pages
import Landing from "./pages/Landing";
import Home from "./pages/Home";
import About from "./pages/About";
import Projects from "./pages/Projects";

//layouts
import DefaultLayout from "./layouts/DefaultLayout";

const App = () => {
  return (
    <BrowserRouter>
      <Routes>
        {/* route della landing page senza layout */}
        <Route path="/" element={<Landing />} />
        {/* route della altre pagine con layout */}
        <Route element={<DefaultLayout />}>
          <Route path="/home" element={<Home />} />
          <Route path="/about" element={<About />} />
          <Route path="/projects" element={<Projects />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App