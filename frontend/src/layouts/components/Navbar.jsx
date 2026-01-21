import React, { useState } from 'react';
import { Link , useLocation } from "react-router-dom";
import * as Dom  from 'react-bootstrap';
import Logo  from '../../assets/logos/jdwblack.png';


const Navbar = () => {
  //hamburger menu
    const [isOpen, setIsOpen] = useState(false);
  

  return (
    <Dom.Navbar bg="white" expand="lg" className="mx-auto ">
      <Dom.Container fluid className="pb-2 border-bottom " >
        <div className="mx-auto max-w-7x1 d-flex w-100 justify-content-between">

        <Dom.Navbar.Brand as={Link} to="/home">
        <img src={Logo} alt="logo jdwdev.it" style={{ height: '3rem' }}/>
        </Dom.Navbar.Brand>
        <Dom.Navbar.Toggle 
          aria-controls="navbarScroll" 
          style={{ 
            border: 'none',
            outline: 'none',
            
            transition: 'all 0.2s ease' // Per transizioni fluide
          }}
          onMouseEnter={(e) => {
            e.target.style.backgroundColor = '#F3F4F6';
            e.target.style.outline = 'none';
            
          }}
          onMouseLeave={(e) => {
            e.target.style.backgroundColor = 'transparent';
            e.target.style.outline = 'none';
            
          }}
          onFocus={(e) => {
            e.target.style.outline = 'none';
            e.target.style.backgroundColor = '#F3F4F6';
          }}
          onClick={() => setIsOpen(!isOpen)}>

          <span className="toggle-icon-wrapper">
          <i  className={isOpen ? 'fa-solid fa-x' : 'fa-solid fa-bars'}></i>
        </span>
          </Dom.Navbar.Toggle>
        <Dom.Navbar.Collapse id="navbarScroll">
          <Dom.Nav className="my-2 me-auto my-lg-0" style={{ maxHeight: '100px' }} navbarScroll>
            <Dom.Nav.Link as={Link} to="/about">About</Dom.Nav.Link>
            <Dom.Nav.Link as={Link} to="/projects">Projects</Dom.Nav.Link>
          </Dom.Nav>
        </Dom.Navbar.Collapse>
        </div>
      </Dom.Container>
      

    </Dom.Navbar>
  );
}

export default Navbar;
