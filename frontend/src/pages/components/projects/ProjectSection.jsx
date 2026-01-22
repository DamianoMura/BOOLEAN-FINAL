import React from 'react'

const ProjectSection = ({section}) => {

  return (
    <div  className="mb-3 border rounded-lg w-100 border-bg-secondary">
          <div className="flex justify-between w-full p-3 mb-2 rounded-t-lg bg-light-blue">
            <div>
              <h4 className="text-lg capitalize">{section.title}</h4>
            </div>
          </div>
          <p className="p-4">{section.content}</p>
          <div className="p-3 text-right text-white rounded-b-lg bg-slate-500">
            <div>
              <span>Created by: </span>
              <span>{section.author || 'N/A'}</span>
            </div>
           
            <div>
              <span>Created: </span>
              <span>{section.created_at || 'N/A'}</span>
            </div>
          </div>
        </div>

  )
}

export default ProjectSection