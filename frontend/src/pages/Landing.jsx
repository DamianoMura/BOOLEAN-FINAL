import React from 'react'
import LandDesc from './components/landing/LandDesc'
import LandImg from './components/landing/LandImg'


const Landing = () => {
 return (
<>
    <header className="sticky-top">
      <nav className="container mt-3 navbar navbar-expand-lg">
        <div className="container-fluid d-flex justify-content-end">
          <div className="user-buttons">
            <a href="http://localhost:8000/login" className="nav-button" >Login</a> or 
            <a href="http://localhost:8000/register" className="nav-button" >Register</a>
          </div>
      </div>
    </nav>
    </header>
    <main className="mb-4">
      <div className="container mt-100">
        <div className="card">
          <div className="container">
            <div className="row">
              <div className="order-2 p-5 col-12 col-lg-6 order-lg-1 d-flex flex-column justify-content-center">
                <LandDesc/>
              </div>
              <div className="order-1 rounded col-12 col-lg-6 order-lg-2 bg-secondary d-flex flex-column justify-content-center align-items-center logo">
                <LandImg/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
</>
  )
}

export default Landing

