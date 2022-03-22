<?php

namespace Tests\Feature\Configs;

use App\Models\Configs\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_storing_a_new_category()
    {
        $category = Category::factory()->count(5)->create();

        $this->assertDatabaseCount('categories', 5);
    }

    public function test_create_a_subcategory()
    {
        $category = Category::factory()->create();
        $subcategory = Category::factory()->create(['parent'=>$category->id]);

        $this->assertDatabaseHas('categories', [
            'parent' => 6
        ]);
    }
}
