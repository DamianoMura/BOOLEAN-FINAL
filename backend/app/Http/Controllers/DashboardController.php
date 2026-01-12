<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;


class DashboardController extends Controller
{

    public function deploy(Request $request)
    {
        // this is the list of components we are receiving from the middleware RoleCheck, so we get only the components that each role can see
        $components = $request->query;
        //in order for the tab view to open the first result we need to pass a string with the tab name on but the component list is of type InputBag
        //we cannot use the input bag as it is so we need to extract that array
        $first = $request->query->all();
        //pass it as a json
        $first = json_encode($first);
        //replace all characters [, " and ] with a empty string
        $first = str_replace('[', '', $first);
        $first = str_replace('"', '', $first);
        $first = str_replace(']', '', $first);
        //then explode it in a new array
        $parts = explode(',', $first);
        //get the first value and pass it on to the dashboard so we can use it to select the first tab of the tab view 
        $first = $parts[0];
        //this way we can pass multiple components and we give the first on list as selected tab

        return view('auth.dashboard', ['components' => $components], ['first' => $first]);
    }
}
