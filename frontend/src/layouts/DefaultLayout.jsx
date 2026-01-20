import { Outlet } from "react-router-dom";
import Navbar from "./components/Navbar";

import Breadcrumbs from "./components/Breadcrumbs";

const DefaultLayout = () => {
  return (
    <div>
			<Navbar />
      <Breadcrumbs/>
			<main className="px-4 mt-40">
        <Outlet />
			</main>
			
		</div>
  )
}

export default DefaultLayout