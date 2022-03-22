<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\Catalogs\Product;
use App\Models\Configs\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_products()
    {
        Product::factory(100)->create();
        $this->assertDatabaseCount('products', 100);
    }

    public function test_adding_categories_to_products()
    {
        $products = Product::factory(50)->create();
        $category = Category::factory()->create();

        foreach ($products as $product) {
            $product->category($category->id);
        }

        $this->assertDatabaseCount('categorizables', 50);
    }

    public function test_adding_tags_to_products()
    {
        $products = Product::factory(50)->create();

        foreach ($products as $product) {
            $product->tag(Str::random(10));
        }

        $this->assertDatabaseCount('tags', 50);
    }
}
