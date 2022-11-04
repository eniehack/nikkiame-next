<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class NewPostTest extends TestCase
{
    public function setup() :void {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_correctly(){
        $response = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->get('/posts/create');
        $response->assertStatus(200);
    }

    public function test_get_without_session(){
        $response = $this->get('/posts/create');
        $response -> assertRedirect('/signin');
    }

    public function test_post_is_success(){
        $array = [
            'title' => 'aaa',
            'content' => 'ddd',
        ];

        $postResponse = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->post('/posts', $array);

        $postResponse -> assertStatus(200);
    }

    public function test_post_is_success_without_title(){
        $array = [
            'title' => '',
            'content' => 'ddd',
        ];

        $postResponse = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->post('/posts', $array);

        $postResponse -> assertStatus(200);
    }

    public function test_post_is_failed(){
        $array = [
            'title' => '',
            'content' => '',
        ];

        $postResponse = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->post('/posts', $array);

        $postResponse -> assertRedirect('/posts/create');
    }

    public function test_expired_session(){
        $array = [
            'title' => 'aaa',
            'content' => 'ddd',
        ];

        $postResponse = $this->actingAs($this->user)
                        ->post('/posts', $array);

        $postResponse -> assertRedirect('/signin');
    }
}
