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
    protected $traction = ['4x4','4x2','AWD', '2WD', 'FWD', 'RWD'];
    protected $position = ['frontal','trasero','inferior', 'superor'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $brandIds = Brand::all()->pluck('id')->toArray();

        $cost = $this->faker->randomFloat(2, 0, 1000);
        $price = ceil($cost * 1.63);

        return [
            'brand_id' => $this->faker->randomElement($brandIds),
            'sku' => Str::random(10),
            'name' => $this->faker->sentence(),
            'description' => $this->faker->text,
            'slug' => $this->faker->unique()->slug(),
            'cost' => $cost,
            'price_wo_tax' => $price / 1.16,
            'price' => $price,
            'stock' => $this->faker->randomDigitNotZero(),
            'notes' => [
                'traction' => $this->traction[rand(0, count($this->traction) - 1)],
                'position' => $this->position[rand(0, count($this->position) - 1)],
            ]
        ];
    }
}
