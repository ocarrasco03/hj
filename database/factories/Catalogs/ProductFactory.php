<?php

namespace Database\Factories\Catalogs;

use App\Models\Catalogs\Brand;
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
        if (Brand::count() < 1){
            $brand = Brand::factory()->create();
        } else {
            $brand = Brand::find(rand(1, Brand::count()));
        }

        $cost = $this->faker->randomFloat(2, 0, 1000);
        return [
            'brand_id' => $brand->id,
            'sku' => Str::random(10),
            'name' => $this->faker->name(),
            'description' => $this->faker->text,
            'slug' => $this->faker->unique()->slug(),
            'cost' => $cost,
            'price_wo_tax' => ($cost * 1.63)/1.16,
            'price' => ceil($cost * 1.63),
            'stock' => $this->faker->randomDigitNotZero(),

        ];
    }
}
