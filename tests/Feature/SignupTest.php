<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\URL;

class SignupTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setup() :void {
        parent::setUp();
        $this->url = URL::temporarySignedRoute(
                'signup.get', now()->addMinutes(30)
        );
    }

    public function test_get()
    {
        $response = $this->get($this->url);
        $response->assertStatus(200);
    }
    public function test_no_signature()
    {
        $response = $this->get('/signup');

        $response->assertStatus(403);
    }

    public function test_user_data_post()
    {
        $array = [
            'name' => 'sampleName',
            'pass' => 'samplePassword',
            'uid' => 'uid',
        ];
        $response = $this->post($this->url, $array);

        $response -> assertRedirect('/signin');
    }

    public function test_duplicate_user_data_post()
    {
        $array = [
            'name' => 'sapmleName',
            'pass' => 'samplePassword',
            'uid' => 'uid',
        ];

        $this->post($this->url, $array);

        $response = $this->post($this->url, $array);

        $response->assertRedirect($this->url);
    }

    public function test_name_empty_post()
    {
        $resp = $this->post($this->url, [
            'pass' => 'password',
            'uid' => 'test',
        ]);

        $resp->assertStatus(302);
    }

    public function test_pass_empty_post()
    {
        $resp = $this->post($this->url, [
            'name' => 'testUser',
            'uid' => 'test',
        ]);

        $resp->assertStatus(302);
    }

    public function test_uid_empty_post()
    {
        $resp = $this->post($this->url, [
            'name' => 'testUser',
            'pass' => 'testPassword',
        ]);

        $resp->assertRedirect($this->url);
    }
}
