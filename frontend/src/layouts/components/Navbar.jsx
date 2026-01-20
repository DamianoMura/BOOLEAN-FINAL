import React from 'react';
import { Link } from "react-router-dom";
import { Navbar, Nav,  Container } from 'react-bootstrap';

const CustomNavbar = () => {
  return (
    <Navbar bg="light" expand="lg" className="px-3">
      <Container fluid>
        <Navbar.Brand as={Link} to="/home">Navbar</Navbar.Brand>
        <Navbar.Toggle aria-controls="navbarScroll" />
        <Navbar.Collapse id="navbarScroll">
          <Nav className="my-2 me-auto my-lg-0" style={{ maxHeight: '100px' }} navbarScroll>
            
            <Nav.Link as={Link} to="/about">About</Nav.Link>
            <Nav.Link as={Link} to="/projects">Projects</Nav.Link>
            
            
          </Nav>
          
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}

export default CustomNavbar;