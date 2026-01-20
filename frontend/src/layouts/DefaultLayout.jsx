import { Outlet } from "react-router-dom";
import Navbar from "./components/Navbar";

const DefaultLayout = () => {
  return (
    <div>
			<Navbar />
			<main>
        <Outlet />
			</main>
			
		</div>
  )
}

export default DefaultLayout