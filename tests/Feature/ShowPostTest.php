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
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create([
            "author" => $this->user->ulid,
            "scope" => 0,
        ]);
    }
    public function test_existing_post() : void {
        $response = $this->get("/@{$this->user->user_id}/p/{$this->post->id}");

        $response->assertStatus(200);
    }
    public function test_invalid_post() : void
    {
        $response = $this->get("/@{$this->user->user_id}/p/01AAAAAAAAAAAAAAAAAAAAAAAA");

        $response->assertStatus(404);
    }
}
