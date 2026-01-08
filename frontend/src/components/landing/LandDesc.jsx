import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faLaravel, faReact, faBootstrap , faCss3  } from '@fortawesome/free-brands-svg-icons';
const LandDesc = () => {
  return (
    <>
      <h1 className="text-center text-primary">Benvenuto nel mio sito web!</h1>
      <p>Questo è il mio sito vetrina dove posterò tutti i progetti ed è sviluppato usando <span className='text-success'><FontAwesomeIcon icon={faReact} /> React.js e  <FontAwesomeIcon icon={faBootstrap} />ootstrap.css</span></p>
      <p>Questa applicazione si interfaccerà con un backoffice basato su  <span className='text-primary'><FontAwesomeIcon icon={faLaravel} /> Laravel 12 e   <FontAwesomeIcon icon={faCss3} /> Tailwind.css </span></p>
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