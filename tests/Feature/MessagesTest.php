<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessagesTest extends TestCase
{
    use RefreshDatabase;

    public function postSuccess(): void
    {
        $response = $this->post(
            '/api/messages',
            [
                'name' => fake()->name(),
                'email' => fake()->safeEmail(),
                'message' => fake()->text(),
            ],
            ['Accept' => 'application/json']
        );

        $response->assertStatus(200);
    }

    public function postFail(): void
    {
        $response = $this->post(
            '/api/messages',
            [],
            ['Accept' => 'application/json']
        );

        $response->assertStatus(422);

        $response->assertJson([
            "name" => ["The name field is required."],
            "email" => ["The email field is required."],
            "message" => ["The message field is required."]
        ]);
    }
}
