import useLocation from 'react'

const NotFound = () => {
  const location=useLocation();

  console.log(location)
  return (
    <div>NotFound</div>
  )
}

export default NotFound