import { Link } from "react-router-dom";
import { useLocation } from "react-router-dom";

const ProjectSnap = ({ project ,children }) => {
  const location = useLocation();
 
  return (
    <div className="p-2 border rounded">
      {/* Project   */}
      <div>
        {/* Project category and Title  */}
        <div className="align-items-center d-flex justify-content-between">
          <div className="gap-2 align-items-center d-flex">
            <div className="category">
              <span>
                {project.category || 'No category'}
              </span>
            </div>
          </div>
          
          {location.pathname === '/projects' && (
            <Link 
            to={`/projects/${project.slug}`} 
            className="d-flex align-items-center justify-self-end text-decoration-none -transform-y-3"
            >
              <i className="fa-solid fa-eye"></i>
              <span className='ms-2 -transform-y-3'>view</span> 
            </Link>
          )}
        </div>
              <div className="mt-2">
                <h3>
                  {project.title || 'No title'}
                </h3>
              </div>
        <div className="mt-3">
            {project.github_url  && (
            <Link 
              to={`${project.github_url}`} 
              className="d-flex align-items-center justify-self-end text-decoration-none -transform-y-3"
              target="_Blank"
            >
              <i className="fa-brands fa-github"></i>
              <span className='ms-2 -transform-y-3'>github Link</span> 
            </Link>
          )}
        </div>
        
        <div>
          {/* Author and view button */}
          <div className="d-flex justify-content-between">
            <div>
              <p>
                Author: <strong>{project.author || 'Unknown'}</strong>
              </p>
            </div>
          </div>
          
          {/* Technologies Tags */}
          {project.technologies && project.technologies.length > 0 && (
            <div className="flex-wrap gap-2 d-flex">
              {project.technologies.map((tech, index) => (
                <span 
                  key={tech.id || index}  
                  className="technology"
                >
                 <strong className="me-2">{tech.label || 'Tech'}</strong> <i className={`${tech.fontawesome_class || ''}`}></i>
                  
                </span>
              ))}
            </div>
          )}
        </div>
        
        <div className='p-2 mt-3'>
          <p>
            <strong>quick description</strong>: {project.description || 'No description available'}
          </p>
        </div>
      {children}
      </div>
    </div>
  );
}

export default ProjectSnap;