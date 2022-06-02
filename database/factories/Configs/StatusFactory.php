<?php

namespace Database\Factories\Configs;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configs\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->colorName(),
            'prefix' => $this->faker->colorName(),
            'level' => $this->faker->randomNumber(),
            'module_name' => $this->faker->name(),
            'unremovable' => $this->faker->boolean(),
            'logable' => $this->faker->boolean(),
            'send_email' => $this->faker->boolean(),
            'shipped' => $this->faker->boolean(),
            'delivered' => $this->faker->boolean(),
            'paid' => $this->faker->boolean(),
        ];
    }
}
