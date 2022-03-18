<?php

namespace Database\Factories\Catalogs;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogs\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sku' => Str::random(10),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'cost' => $this->faker->randomFloat(2, 0, 1000),
            'price_wo_taxt' => $this->faker->randomFloat(2, 0, 1000),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'stock' => $this->faker->randomDigitNotZero(),

        ];
    }
}
