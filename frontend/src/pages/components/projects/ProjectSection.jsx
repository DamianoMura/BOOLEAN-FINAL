import React from 'react'

const ProjectSection = ({section}) => {

  return (
    <div  className="mb-3 border rounded-lg w-100 border-bg-secondary">
          <div className="w-full p-3 mb-2 rounded-t-lg justifycontent-between d-flex bg-light-blue">
            <div>
              <h4 className="text-lg capitalize">{section.title}</h4>
            </div>
          </div>
          <p className="p-4">{section.content}</p>
          
        </div>

  )
}

export default ProjectSection