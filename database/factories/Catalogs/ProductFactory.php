<?php

namespace Database\Factories\Catalogs;

use App\Models\Catalogs\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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

        $brand = Brand::factory()->create();

        $cost = $this->faker->randomFloat(2, 0, 1000);
        $price = ceil($cost * 1.63);

        return [
            'brand_id' => $brand->id,
            'sku' => Str::random(10),
            'name' => $this->faker->name(),
            'description' => $this->faker->text,
            'slug' => $this->faker->unique()->slug(),
            'cost' => $cost,
            'price_wo_tax' => $price / 1.16,
            'price' => $price,
            'stock' => $this->faker->randomDigitNotZero(),

        ];
    }
}
