<?php

namespace App\Imports\Catalogs;

use App\Models\Catalogs\Brand;
use App\Models\Catalogs\Product;
use App\Models\Configs\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ProductsImport implements ToCollection, WithProgressBar, WithChunkReading, WithBatchInserts, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        foreach ($collection as $row) {
            $brand = $this->getBrand($row['brand']);
            $category = $this->getCategory($row['category']);
            $subcategory = $this->getCategory($row['subcategory'], $category->id);

            $product = Product::where('brand_id', $brand->id)->where('sku', $row['sku'])->first();

            if (!$product) {
                $product = new Product();
                $product->brand_id = $brand->id;
                $product->sku = $row['sku'];
                $product->name = $row['name'];
                $product->slug = Str::slug($row['sku'] . ' ' . $row['name'] . ' ' . $row['brand']);
                $product->cost = $row['cost'];
                $product->price_wo_tax = $row['price'] / 1.16;
                $product->price = $row['price'];
                $product->stock = $row['stock'];
                $product->save();
            }

            $product->category([$category->id, $subcategory->id]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Check if the brand name exist or create a new one.
     *
     * @param string $name
     * @return \App\Models\Catalogs\Brand
     */
    public function getBrand($name)
    {
        $brand = Brand::where('name', $name)->first();

        if (!$brand) {
            $brand = new Brand();
            $brand->name = $name;
            $brand->save();
        }

        return $brand;
    }

    public function getCategory($name, $parent = 0)
    {
        $category = Category::where('parent', $parent)->where('name', $name)->first();

        if (!$category) {
            $category = new Category();
            $category->name = $name;
            $category->parent = $parent;
            $category->save();
        }

        return $category;
    }
}
