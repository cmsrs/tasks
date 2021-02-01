<?php 
namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Project;

class DashboardController extends Controller {

	public function getIndex( Request $request )
	{
        $this->data['projects']  = Project::getAllProjects();
		return view('dashboard', $this->data);
	}	


}
