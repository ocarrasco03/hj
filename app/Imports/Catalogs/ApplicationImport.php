<?php

namespace App\Imports\Catalogs;

use App\Models\Vehicles\Year;
use App\Models\Vehicles\Model;
use App\Models\Catalogs\Product;
use App\Models\Vehicles\Catalog;
use Illuminate\Support\Collection;
use App\Models\Vehicles\Manufacturer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ApplicationImport implements ToCollection, WithHeadingRow, WithProgressBar, WithChunkReading, WithBatchInserts, ShouldQueue
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        ini_set('max_execution_time',0);
        foreach ($collection as $row) {
            $make = $this->getMake($row['make']);
            $model = $this->getModel($make->id, $row['model']);
            $product = Product::where('sku', $row['sku'])->whereHas('brand', function($query) use ($row) {
                return $query->where('name', $row['brand']);
            })->first();
            if ($row['from'] !== 'TODOS') {
                $years = [];
                for ($i = $row['from']; $i <= $row['to']; $i++) {
                    $year = $this->getYear($i);
                    $years[] = $year->id;
                    if ($product) {
                        $this->attachToCatalog($product->id, $year->id, $make->id, $model->id, null, $row['notes']);
                    }
                }
                $model->storeYear($years);
            }
        }
    }

    public function getMake($name)
    {
        $make = Manufacturer::where('name', $name)->first();

        if (!$make) {
            $make = new Manufacturer();
            $make->name = $name;
            $make->save();
        }

        return $make;
    }

    public function getModel($make, $name)
    {
        $model = Model::where('make_id', $make)->where('name', $name)->first();

        if (!$model) {
            $model = new Model();
            $model->make_id = $make;
            $model->name = $name;
            $model->save();
        }

        return $model;
    }

    public function getYear($fullYear)
    {
        $year = Year::where('year', $fullYear)->first();

        if (!$year) {
            $year = new Year();
            $year->year = $fullYear;
            $year->save();
        }

        return $year;
    }

    public function attachToCatalog($product, $year, $make, $model, $engine = null, $notes = null, array $attributes = [])
    {
        $catalog = new Catalog();
        $catalog->product_id = $product;
        $catalog->year_id = $year;
        $catalog->make_id = $make;
        $catalog->model_id = $model;
        $catalog->engine_id = $engine;
        $catalog->notes = $notes;
        $catalog->attributes = !empty($attributes) ? $attributes : null;
        $catalog->save();
    }

    /**
     * @return integer
     */
    public function chunkSize(): int
    {
        return 10;
    }

    /**
     * @return integer
     */
    public function batchSize(): int
    {
        return 10;
    }
}
