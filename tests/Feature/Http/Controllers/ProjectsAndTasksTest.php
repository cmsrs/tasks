<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProjectsAndTasksTest extends TestCase
{
    public function testAdd()
    {
        $d = 
        [
            [
                'title' => 'Konfiguracja serwera',
                'tasks' => [
                    [ 'name' => 'Instalacja nginix-a', 'points' => 2 ],
                    [ 'name' => 'Dodanie ssl-a', 'points' => 6 ],                
                ]
            ],
        ];
        $r = $this->post( '/projetsandtasks', $d );
        $r->assertStatus(302);    
    }

    public function testShow()
    {
        $r = $this->get( '/projetsandtasks' );
        $r->assertStatus(200);
    }

}


