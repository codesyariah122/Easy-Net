<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => strtolower(trim(preg_replace('/\s+/', '_', $this->faker->name()))),
            'email_verified_at' => now(),
            'phone' => '08xxxxxxxx1x',
            'roles' => json_encode(["CUSTOMER"]),
            'password' => \Hash::make("123654Bismillah"), // password
            'status' => 'INACTIVE',
            'city' => 'your city',
            'province' => 'you  province',
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
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
