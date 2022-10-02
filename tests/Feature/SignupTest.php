<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignupTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/signup');

        $response->assertStatus(200);
    }

    public function test_user_data_post()
    {
        $array = [
            'name' => 'sampleName',
            'pass' => 'samplePassword',
            'uid' => 'uid',
        ];
        $response = $this->post('/signup', $array);

        $response -> assertStatus(201);
    }

    public function test_duplicate_user_data_post()
    {
        $array = [
            'name' => 'sapmleName',
            'pass' => 'samplePassword',
            'uid' => 'uid',
        ];

        $this->post('/signup', $array);

        $response = $this->post('/signup', $array);

        $response->assertRedirect('/signup');
    }

    public function test_name_empty_post()
    {
        $resp = $this->post('/signup', [
            'pass' => 'password',
            'uid' => 'test',
        ]);

        $resp->assertStatus(302);
    }

    public function test_pass_empty_post()
    {
        $resp = $this->post('/signup', [
            'name' => 'testUser',
            'uid' => 'test',
        ]);

        $resp->assertStatus(302);
    }

    public function test_uid_empty_post()
    {
        $resp = $this->post('/signup', [
            'name' => 'testUser',
            'pass' => 'testPassword',
        ]);

        $resp->assertRedirect('/signup');
    }
}
https://vscode.dev/liveshare/3ACA5092AB03752D94EF3C7AC5C7E400B1EE
