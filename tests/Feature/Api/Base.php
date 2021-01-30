<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class Base extends TestCase
{
    protected $token;    
    const PASSWORD1 = 'tasks1'; 
    const STR_PROJ_TITLE_ONE = 'HR - Manage clients';
    const STR_PROJ_TITLE_TWO = 'Sports - Basketball teams'; 


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


}