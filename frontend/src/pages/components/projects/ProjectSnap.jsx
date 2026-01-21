import React from 'react'

const ProjectSnap = ({project}) => {
  
  return (
    <div className="flex-col p-4 space-y-3 transition-colors duration-200 border border-gray-100 rounded-lg d-flex bg-gradient-to-r from-gray-50/50 to-white hover:border-blue-200 ">

     {/* Project   */}
    
    
    <div className="flex flex-col">
        <div className="flex flex-col space-y-3">
             {/* Project ID and Title  */}
            <div className="flex items-center space-x-4">
                <div
                    className="flex items-center justify-center px-2 py-3 border border-blue-200 rounded-lg bg-gradient-to-br from-blue-100 to-blue-50">
                    <span>
                        { project.category.label }
                    </span>
                </div>
                <div className="flex">
                    <span className="text-lg font-semibold text-gray-800 capitalize sm:text-3xl">
                      { project.title }</span>
                </div>
            </div>
            <div className="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3 sm:justify-between ">
                <div className="flex items-center justify-between space-x-3">
                    <p className="mt-1 capitalize text-bold ">
                        { project.author.name }
                    </p>
                    
                 
                <div className="flex items-center mt-3 space-x-3 sm:mt-0">
                  
                    
                        <a href="#" className="items-center">
                            <i className="fa-solid fa-eye"></i>
                            view
                        </a>
                   
                    
                </div>
            </div>
             {/* Technologies Tags   */}
            {project.technologies &&
            (<div className="flex flex-wrap gap-1 -top-2">
              {project.technologies.map((tech, index) => (
                <span 
                  key={index}  
                  className="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full"
                >
                  {tech.label} <i className={`${tech.fontawesome_class}`}></i>
                </span>
              ))}
            
            </div>)
            }
              
        </div>
   </div>
   </div>
   </div>
  )
}

export default ProjectSnap