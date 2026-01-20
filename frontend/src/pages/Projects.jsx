import React from 'react'
import Filters from './components/landing/projects/Filters'

const Projects = () => {
  return (
    <div className="p-5 bg-white rounded-lg shadow">
      <div className="row">
        <div className="col-12">
          <p>Here you can find all of my projects!</p>
        </div>
        <div className="col-12">
          <Filters/>
        </div>
      </div>

    </div>
  )
}

export default Projects