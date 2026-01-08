import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faLaravel, faReact, faBootstrap , faCss3  } from '@fortawesome/free-brands-svg-icons';
const LandDesc = () => {
  return (
    <>
      <h1 className="text-center text-primary">Benvenuto nel mio sito web!</h1>
      <p>Questo è il mio sito vetrina dove posterò tutti i progetti ed è sviluppato usando  React.js <FontAwesomeIcon icon={faReact} /> e   bootstrap.css <FontAwesomeIcon icon={faBootstrap} /></p>
      <p>Questa applicazione si interfaccerà con un backoffice basato su  Laravel 12 <FontAwesomeIcon icon={faLaravel} /> e   Tailwind.css <FontAwesomeIcon icon={faCss3} />  </p>
      <p>
       Gli utenti registrati possono inserire i propri progetti personali con relativi link.
       </p>
       <p>
        Se invece vuoi solo dare un'occhiata ti basterà cliccare qui sotto per entrare
       </p>
       <div className="text-center">
        <a href="#" className="mb-3 btn btn-outline-primary justify-self-center"> entra</a>
       </div>
   </>
  )
}

export default LandDesc