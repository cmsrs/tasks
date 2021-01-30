<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class Base extends TestCase
{
    protected $token;    
    const PASSWORD1 = 'tasks1'; 
    const STR_PROJ_TITLE_ONE = 'HR - Manage clients';
    const STR_PROJ_TITLE_TWO = 'Sports - Basketball teams'; 

    const STR_TASK_NAME_ONE = 'prepare Server';
    const STR_TASK_NAME_TWO = 'create Mock';    

    const POINTS = 98;    


    public function createUser()
    {
        $user = new User([
            'email'    => 'unittest2@email.com',
            'name'     => 'test testowy',
            'role' => 'admin'
        ]);

        $user->password = self::PASSWORD1;
        $user->save();

        $this->token = $this->post('api/login', [
            'email'    => 'unittest2@email.com',
            'password' => self::PASSWORD1
        ])->getData()->data->token;;        
    }    

    public function deleteUser()
    {
        $user = User::where('email', 'unittest2@email.com');
        $user->delete();
    }

    public function addProject()
    {
        $testData = [
            'title' => self::STR_PROJ_TITLE_ONE
        ];

        $response = $this->post('api/projects?token='.$this->token, $testData);
        $res = $response->getData();
        $this->assertTrue($res->success);        

        $arrProject = Project::All()->toArray();
        $this->assertEquals( 1, count($arrProject)  );        
        $this->assertEquals( self::STR_PROJ_TITLE_ONE, $arrProject[0]['title']);
        $this->assertNotEmpty( $arrProject[0]['id']);        
        $projectId = $arrProject[0]['id'];
        return $projectId;
    }

    public function addTask($projectId)
    {
        $testData = [
            'name' => self::STR_TASK_NAME_ONE,
            'points' => 98,
            'project_id' => $projectId
        ];

        $response = $this->post('api/tasks?token='.$this->token, $testData);
        $res = $response->getData();
        $this->assertTrue($res->success);        

        $arrTask = Task::All()->toArray();
        $this->assertEquals( 1, count($arrTask)  );        
        $this->assertEquals( self::STR_TASK_NAME_ONE, $arrTask[0]['name']);
        $this->assertEquals( self::POINTS, $arrTask[0]['points']);        
        $this->assertEquals( $projectId, $arrTask[0]['project_id']);                
        $this->assertNotEmpty( $arrTask[0]['id']);        
        $taskId = $arrTask[0]['id'];
        return $taskId;
    }

}