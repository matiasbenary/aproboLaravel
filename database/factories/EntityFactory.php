<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'business_name' => fake()->name(),
            'fantasy_name' => fake()->name(),
            'cuit' => fake()->numerify('###########'),
            'cbu' => fake()->numerify('###############'),
            'email' => fake()->unique()->safeEmail(),
            'invitation_token' => fake()->uuid(),
        ];
    }
}
