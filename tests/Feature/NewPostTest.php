<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class NewPostTest extends TestCase
{

    use RefreshDatabase;

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
                        ->get('/posts/new');
        $response->assertStatus(200);
    }

    public function test_get_without_session(){
        $response = $this->get('/posts/new');
        $response -> assertRedirect('/signin');
    }

    public function test_public_post_is_success(){
        $array = [
            'title' => 'aaa',
            'content' => 'ddd',
            "scope" => "0",
        ];

        $postResponse = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->post('/posts/new', $array);

        $postResponse -> assertStatus(201);
    }

    public function test_private_post_is_success(){
        $array = [
            'title' => 'aaa',
            'content' => 'ddd',
            "scope" => "1",
            "pass_phrase" => "password",
        ];

        $postResponse = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->post('/posts/new', $array);

        $postResponse -> assertStatus(201);
    }

    public function test_post_is_success_without_title(){
        $array = [
            'title' => '',
            'content' => 'ddd',
            "scope" => "0",
        ];

        $postResponse = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->post('/posts/new', $array);

        $postResponse -> assertStatus(201);
    }

    public function test_post_is_failed(){
        $array = [
            'title' => '',
            'content' => '',
            "scope" => "0",
        ];

        $postResponse = $this->actingAs($this->user)
                        ->withSession(["name" => $this->user->name, "ulid" => $this->user->ulid, "uid" => $this->user->user_id])
                        ->post('/posts/new', $array);

        $postResponse -> assertRedirect('/posts/new');
    }

    public function test_expired_session(){
        $array = [
            'title' => 'aaa',
            'content' => 'ddd',
            "scope" => "0",
        ];

        $postResponse = $this->actingAs($this->user)
                        ->post('/posts/new', $array);

        $postResponse -> assertRedirect('/signin');
    }
}
