<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    const PASSWORD = 'tasks1';

    public function setUp(): void
    {
        parent::setUp();

        $user = new User([
             'email'    => 'test@email.com',
             'name'     => 'test testowy',
             'role' => 'admin'
         ]);

        $user->password = self::PASSWORD;
        $user->save();

        $arrUsers = User::all()->toArray();
        $this->assertEquals( 'admin', $arrUsers[0]['role']);
    }

    private function privilege_action($token)
    {
        $response = $this->get('api/projects?token='.$token);
        return $response;
    }


    private function logout_action($token)
    {
        $response = $this->get('api/logout?token='.$token);
        return $response;
    }

    /** @test */
    public function it_will_log_a_user_in()
    {
        $d  = [
            'email'    => 'test@email.com',
            'password' => self::PASSWORD
        ];

        $response = $this->post('api/login', $d); //->getData();
        $response = $response->getData();

        $this->assertStringStartsWith('eyJ0eXA', $response->data->token);
        $this->assertTrue($response->success);

        $privilege =  $this->privilege_action($response->data->token);
        $this->assertTrue($privilege->getData()->success);

        $logout =  $this->logout_action($response->data->token);

        $this->assertTrue($logout->getData()->success);
        $privilegeAfterLogout =    $this->privilege_action($response->data->token);
    }

    /** @test */
    public function it_will_log_client_in()
    {
        $user = new User([
            'email'    => 'client@email.com',
            'name'     => 'client test',
            'role' => 'client'
        ]);
    
        $user->password = 'test_fake';
        $user->save();

        $response = $this->post('api/login', [
            'email'    => 'client@email.com',
            'password' => 'test_fake'
        ])->getData();

        $this->assertFalse($response->success);
    }

    /** @test */
    public function it_will_not_log_an_invalid_user_in()
    {
        $response = $this->post('api/login', [
            'email'    => 'test@email.com',
            'password' => 'wrongpass'
        ])->getData();

        $this->assertNotEmpty($response->error);
    }
}
