
import { Link } from "react-router-dom";
import { useNavigate, useLocation } from "react-router-dom";
const ProjectSnap = ({project}) => {
  const location=useLocation();
  
  return (
    <div key={project.id} className="p-2 border rounded ">
      {/* Project   */}
        <div className="">
             {/* Project category and Title  */}
            <div className="align-items-center d-flex justify-content-between">
              <div className="gap-2 align-items-center d-flex">

                <div className="category">
                    <span>
                        { project.category.label }
                    </span>
                </div>
                <div >
                    <h3 >
                      { project.title }</h3>
                </div>
              </div>{location.pathname='/projects'&& 
                (<Link to ={`/projects/${project.slug}`} className="d-flex align-items-center justify-self-end text-decoration-none -transform-y-3">
                      <i className="fa-solid fa-eye"></i>
                      <span className='ms-2 -transform-y-3'>view</span> 
                </Link>)
                 }
                
            </div>
            
            <div>
             {/* Author and view button */}
                <div className="d-flex justify-content-between" >
                    <div>
                      <p>
                       Author : <strong> { project.author.name }</strong>
                      </p>
                    </div>
                </div>
             {/* Technologies Tags   */}
            {project.technologies &&
            (<div className="flex-wrap gap-2 d-flex">
              {project.technologies.map((tech, index) => (
                <span 
                  key={index}  
                  className="technology"
                >
                  {tech.label} <i className={`${tech.fontawesome_class}`}></i>
                </span>
              ))}
            
            </div>)
            }
              
        </div>
        <div className='p-2 mt-3'>
          <p>
            <strong> quick description </strong> : {project.description}
          </p>
                    </div>
   </div>
   </div>
   
  )
}

export default ProjectSnap