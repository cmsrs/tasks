<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;


class ProjectsAndTasks extends Controller {

	/**
	 * zapis do bazy danych projekow i nalezacych do nich 'taskow'
	 * przykladowe dane z posta:
	 * [
	 *	[
	 *		'title' => 'Konfiguracja serwera',
	 *		'tasks' => [
	 *			[ 'name' => 'Instalacja nginix-a', 'points' => 2 ],
	 *			[ 'name' => 'Dodanie ssl-a', 'points' => 6 ],                
	 *		]
	 *	],
	 *];
	 */
	public function add( Request $request )
	{
		$post = $request->all();

		foreach($post as $project){			
			$objProject = Project::create(['title' => $project['title'] ]);
			foreach($project['tasks'] as $task ){
				Task::create([
					'name' => $task['name'],
					'points' => $task['points'],
					'project_id'=> $objProject->id
					]);		
			}
		}
		return redirect()->route('show');
	}		

	/**
	 * wyswietlenie wszystkich projektow i nalezacych do nich 'taskow'
	 */
	public function show()
	{
		$show = [];
		$projects = Project::all();
		$i = 0;
		foreach($projects as $project){
			$show[$i]['title'] = $project->title;
			$show[$i]['tasks'] = Task::where('project_id', '=', $project->id)->get()->toArray();
			$i++;
		}
		return view('projectsandtasks', [ 'show' => $show] );
	}
  
}
