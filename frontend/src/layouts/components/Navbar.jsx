import React from 'react';
import { Link } from "react-router-dom";
import * as Dom from 'react-bootstrap';

const CustomNavbar = () => {
  return (
    <Dom.Navbar bg="light" expand="lg" className="px-3">
      <Dom.Container fluid>
        <Dom.Navbar.Brand as={Link} to="/home">Navbar</Dom.Navbar.Brand>
        <Dom.Navbar.Toggle aria-controls="navbarScroll" />
        <Dom.Navbar.Collapse id="navbarScroll">
          <Dom.Nav className="my-2 me-auto my-lg-0" style={{ maxHeight: '100px' }} navbarScroll>
            <Dom.Nav.Link as={Link} to="/about">About</Dom.Nav.Link>
            <Dom.Nav.Link as={Link} to="/projects">Projects</Dom.Nav.Link>
          </Dom.Nav>
        </Dom.Navbar.Collapse>
      </Dom.Container>
    </Dom.Navbar>
  );
}

export default CustomNavbar;