import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faLaravel, faReact, faBootstrap , faCss3  } from '@fortawesome/free-brands-svg-icons';
import { Link } from "react-router-dom";
const LandDesc = () => {
  return (
    <>
      <div className="p-3 mb-4 border rounded bg-light border-primary-subtle">
        <h5 className="mb-2 text-primary"><i className="fa-solid fa-circle-info me-2"></i>Live Demo</h5>
        <p className="mb-1 small">
          This is a <strong>live demo</strong> of a full-stack portfolio application built as the final project
          for the <strong>Boolean</strong> Full-Stack Web Development course (600 hours).
        </p>
        <p className="mb-1 small">
          <strong>Backend:</strong> Laravel 11 <FontAwesomeIcon icon={faLaravel} /> with role-based backoffice (Dev, Admin, User),
          REST API, HTML-sanitized project sections, and Eloquent ORM with SQLite.
        </p>
        <p className="mb-1 small">
          <strong>Frontend:</strong> React 19 <FontAwesomeIcon icon={faReact} /> SPA with Bootstrap 5 <FontAwesomeIcon icon={faBootstrap} />,
          dynamic filtering, pagination, and Axios API integration.
        </p>
        <p className="mb-0 small text-muted">
          Each demo session gets a fresh database copy — feel free to create, edit, and delete freely.
        </p>
      </div>

      <h1 className="text-center text-primary">Welcome!</h1>
      <p>
        Explore the public project showcase below, or log into the backoffice to see the
        role-based dashboard in action.
      </p>
      <div className="text-center">
        <Link to="/home" className="mb-3 btn btn-outline-primary justify-self-center">Explore Projects</Link>
        <div>
          <p>Try the backoffice with different roles</p>
          <div>
            <a href={`${import.meta.env.VITE_BACKEND_URL}/login`} className="btn btn-primary">Enter Demo Backoffice</a>
          </div>
        </div>
      </div>
    </>
  )
}

export default LandDesc
