<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->realText(20),
            'author' => fake()->unique()->regexify("[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{26}"),
            "is_draft" => false,
            "content" => fake()->realText(),
            "created_at" => now(),
            "updated_at" => now(),
            "scope" => 0,
            "id" => fake()->unique()->regexify("[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{26}"),
        ];
    }
}