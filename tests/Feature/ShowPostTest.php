<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;


class ShowPostTest extends TestCase
{

    use RefreshDatabase;

    public function setup() : void {
        parent::setUp();
        $user = User::factory()->create();
        $this->post = Post::factory()->create([
            "author" => $user->ulid
        ]);
    }
    public function test_existing_post() : void {
        $response = $this->get('/posts'."/".$this->post->id);

        $response->assertStatus(200);
    }
    public function test_invalid_post() : void
    {
        $response = $this->get('/posts'."/"."01AAAAAAAAAAAAAAAAAAAAAAAA");

        $response->assertStatus(404);
    }
}
