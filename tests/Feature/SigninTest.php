<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class SigninTest extends TestCase
{
    use RefreshDatabase;


    public function setup() : void {
        parent::setUp();
        $user = User::factory()->create([
            'user_id' => 'testuser',
        ]);
    }

    public function test_get_signinpage(){
        $response=$this->get('/signin');
        $response->assertStatus(200);
    }

    public function test_empty_post(){
        $array = [
            'pass' => '',
            'uid' => '',
        ];
        $response = $this->post('/signin', $array);

        $response -> assertRedirect('/signin');
    }

    public function test_wrong_post(){
        $array = [
            'pass' => 'aaaaaaaa',
            'uid' => 'a',
        ];
        $response = $this->post('/signin', $array);

        $response -> assertRedirect('/signin');
    }

    public function test_correct_post(){
        $array = [
            'pass' => 'password',
            'uid' => 'testuser',
        ];
        $response = $this->post('/signin', $array);

        $response -> assertRedirect('/');
    }
}
