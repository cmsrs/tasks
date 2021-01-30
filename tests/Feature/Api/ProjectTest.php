<?php
namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class ProjectTest extends Base
{
    use RefreshDatabase;    

    public function setUp(): void
    {
        parent::setUp();
        $this->createUser();                        
    }

    protected function tearDown(): void
    {
        $this->deleteUser();        
        parent::tearDown();
    }

    /** @test */
    public function it_will_add_project()
    {
        $this->addProject();
    }    

    /** @test */
    public function it_will_update_project()
    {
        $projectId =$this->addProject();

        //update
        $testData2 = [
            'title' => self::STR_PROJ_TITLE_TWO
        ];

        $response2 = $this->put('api/projects/'.$projectId.'?token='.$this->token, $testData2);
        $res2 = $response2->getData();
        $this->assertTrue($res2->success);        

        $arrProject2 = Project::All()->toArray();
        $this->assertEquals( 1, count($arrProject2)  );        
        $this->assertEquals( self::STR_PROJ_TITLE_TWO, $arrProject2[0]['title']);
    }    

    /** @test */
    public function it_will_delete_project()
    {
        $projectId =$this->addProject();        
        $this->addTask($projectId);

        $arrProject = Project::All()->toArray();
        $this->assertEquals( 1, count($arrProject)  );        

        $arrTask = Task::All()->toArray();
        $this->assertEquals( 1, count($arrTask)  );        

        //delete
        $response2 = $this->delete('api/projects/'.$projectId.'?token='.$this->token);
        $res2 = $response2->getData();
        $this->assertTrue($res2->success);        

        $arrProject2 = Project::All()->toArray();
        $this->assertEquals( 0, count($arrProject2)  );        

        $arrTask = Task::All()->toArray();
        $this->assertEquals( 0, count($arrTask)  );        
        
    }

    /** @test */
    public function it_will_get_project()
    {
        //add
        $projectId =$this->addProject();        
        $this->addTask($projectId);

        //get
        $response2 = $this->get('api/projects?token='.$this->token);
        $res2 = $response2->getData();
        $this->assertTrue($res2->success);   

        $this->assertEquals(1, count($res2->data));
        $this->assertEquals(self::STR_PROJ_TITLE_ONE, $res2->data[0]->title);


        $this->assertEquals(1, count($res2->data[0]->tasks));
        $this->assertEquals(Base::STR_TASK_NAME_ONE,  $res2->data[0]->tasks[0]->name );        
        $this->assertEquals(Base::POINTS,  $res2->data[0]->tasks[0]->points );                
        $this->assertEquals($projectId,  $res2->data[0]->tasks[0]->project_id );
    }

}