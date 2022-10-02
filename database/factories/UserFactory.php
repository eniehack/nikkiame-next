<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'user_id' => fake()->unique()->regexify("^[0-9a-z._]{1,20}$"),
            'password' =>  '$argon2id$v=19$m=65536,t=4,p=1$cnpQRU9JMmZ2cDl0dmM3TQ$TEqRcALmWZfUnnmvodyhTA',
            "updated_at" => now(),
            "created_at" => now(),
            "ulid" => fake()->unique()->regexify("[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{26}"),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
