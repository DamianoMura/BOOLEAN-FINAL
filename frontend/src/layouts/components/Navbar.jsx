// chiedo scusa mi sono aiutato un pò con l'ia per creare il navbar - poi ho modificato per rispecchiare ciò che ho fatto su laravel(tempistiche ristrette)
import React, { useState } from 'react';
import { Link, useLocation } from "react-router-dom";
import Logo from '../../assets/logos/jdwblack.png';

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);
  const location = useLocation();

  return (
    <nav className="bg-white shadow-sm navbar navbar-expand-lg navbar-light border-bottom">
      <div className="container h-100">
        {/* Logo - */}
        <Link className="navbar-brand" to="/">
          <img 
            src={Logo} 
            alt="logo jdwdev.it" 
            height="68"
            className="py-2 align-top d-inline-block"
          />
        </Link>

        {/* Toggler */}
        <button 
          className="border-0 navbar-toggler" 
          type="button" 
          onClick={() => setIsOpen(!isOpen)}
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        {/* Menu */}
        <div className={`collapse navbar-collapse ${isOpen ? 'show' : ''}`}>
          <ul className=" navbar-nav mb-lg-0">
            <NavItem 
              to="/home" 
              location={location}
              iconSolid="fa-home"
              iconRegular="fa-home"
              text="Home"
            />
            <NavItem 
              to="/about" 
              location={location}
              iconSolid="fa-address-book"
              iconRegular="fa-address-book"
              text="About"
            />
            
            <NavItem 
              to="/projects" 
              location={location}
              iconSolid="fa-folder"
              iconOpen="fa-folder-open"
              text="Projects"
            />
          </ul>
        </div>
      </div>
    </nav>
  );
};

// Componente NavItem riutilizzabile
const NavItem = ({ to, location, iconSolid, iconRegular, iconOpen, text }) => {
  const isActive = location.pathname.startsWith(to);
  
  
  return (
    <li className="nav-item">
      <Link 
        className={`px-2 nav-link d-flex align-items-center ${isActive ? 'active fw-semibold' : ''}`}
        to={to}
      >
        <div className="nav-icon position-relative me-2 " style={{ width: '24px' }}>
          {/* Icona solida - visibile di default */}
          <i className={`fa-solid ${iconSolid} `}></i>
          
          {/* Icona hover - nascosta di default */}
          <i 
            className={` fa-${iconRegular ? 'regular' : 'solid'} ${iconRegular || iconOpen} position-absolute start-0 translate-y opacity-0 hover-show `}
            
          ></i>
        </div>
        <span>{text}</span>
      </Link>
    </li>
  );
};

export default Navbar;