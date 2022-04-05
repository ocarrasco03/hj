<?php

namespace App\Imports\Catalogs;

use App\Models\Catalogs\Product;
use App\Models\Vehicles\Catalog;
use App\Models\Vehicles\Manufacturer;
use App\Models\Vehicles\Model;
use App\Models\Vehicles\Year;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ApplicationImport implements ToCollection, WithHeadingRow, WithProgressBar, WithChunkReading, WithBatchInserts
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
            $make = $this->getMake($row['make']);
            $model = $this->getModel($make->id, $row['model']);
            $attachments = [];
            foreach ($row as $key => $value) {
                if ($key !== 'sku' && $key !== 'brand' && $key !== 'model' && $key !== 'make' && $key !== 'notes' && $key !== 'from' && $key !== 'to') {
                    if ($value !== '-') {
                        $attachments[$key] = $value;
                    }
                }
            }
            $product = Product::where('sku', $row['sku'])->whereHas('brand', function ($query) use ($row) {
                return $query->where('name', $row['brand']);
            })->first();
            if ($row['from'] !== 'TODOS' && $row['from'] !== '-') {
                $years = [];
                for ($i = $row['from']; $i <= $row['to']; $i++) {
                    $year = $this->getYear($i);
                    $years[] = $year->id;
                    if ($product) {
                        $notes = ($row['notes'] !== '-' && !empty($row['notes'])) ? $row['notes'] : null;
                        $this->attachToCatalog($product->id, $year->id, $make->id, $model->id, null, $notes, $attachments);
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
        // $catalog->attributes = !empty($attributes) ? [$attributes] : null;
        $catalog->attributes = !empty($attributes) ? json_encode($attributes) : null;
        $catalog->save();
    }

    /**
     * @return integer
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * @return integer
     */
    public function batchSize(): int
    {
        return 500;
    }
}
