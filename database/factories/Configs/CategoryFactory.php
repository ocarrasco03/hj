<?php

namespace Database\Factories\Configs;

use App\Models\Configs\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configs\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory´s corresponign model.
     *
     * @var string
     */
    protected $model = Category::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
