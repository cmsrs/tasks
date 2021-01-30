<?php
namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class TaskTest extends Base
{
    use RefreshDatabase;  
    
    private $projectId;

    public function setUp(): void
    {
        parent::setUp();
        $this->createUser();      
        $this->projectId = $this->addProject();
    }

    protected function tearDown(): void
    {
        $this->projectId = null;
        $this->deleteUser();        
        parent::tearDown();
    }

    /** @test */
    public function it_will_add_task()
    {
        $this->addTask($this->projectId);
    }    

    /** @test */
    public function it_will_update_task()
    {
        $taskId =$this->addTask($this->projectId);

        //update
        $testData2 = [
            'name' => self::STR_TASK_NAME_TWO,
            'points' => 1232,
            'project_id' => $this->projectId
        ];

        $response2 = $this->put('api/tasks/'.$taskId.'?token='.$this->token, $testData2);
        $res2 = $response2->getData();
        $this->assertTrue($res2->success);        

        $arrTask2 = Task::All()->toArray();
        $this->assertEquals( 1, count($arrTask2)  );        
        $this->assertEquals( self::STR_TASK_NAME_TWO, $arrTask2[0]['name']);
        $this->assertEquals( 1232, $arrTask2[0]['points']);        
        $this->assertEquals( $this->projectId, $arrTask2[0]['project_id']);                
    }    

    /** @test */
    public function it_will_delete_task()
    {
        $taskId =$this->addTask($this->projectId);

        //delete
        $response2 = $this->delete('api/tasks/'.$taskId.'?token='.$this->token);
        $res2 = $response2->getData();
        $this->assertTrue($res2->success);        

        $arrTask2 = Task::All()->toArray();
        $this->assertEquals( 0, count($arrTask2) );        
    }

    /** @test */
    public function it_will_get_task()
    {
        //add
        $taskId =$this->addTask($this->projectId);

        //get
        $response2 = $this->get('api/tasks?token='.$this->token);
        $res2 = $response2->getData();
        $this->assertTrue($res2->success);   

        $this->assertEquals(1, count($res2->data));
        $this->assertEquals(self::STR_TASK_NAME_ONE, $res2->data[0]->name);
        $this->assertEquals(Base::POINTS, $res2->data[0]->points);
        $this->assertEquals($this->projectId, $res2->data[0]->project_id);        
    }

}