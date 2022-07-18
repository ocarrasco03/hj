<?php

namespace App\Imports\Catalogs;

use App\Models\Catalogs\Product;
use App\Models\Vehicles\Catalog;
use App\Models\Vehicles\Manufacturer;
use App\Models\Vehicles\Model;
use App\Models\Vehicles\Vehicle;
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
                        $this->createVehicle($year->id, $make->id, $model->id, null);
                        $product->attachVehicle($year, $make, $model, null, $notes, $attachments);
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

    public function createVehicle($year, $make, $model, $engine = null)
    {
        $vehicle = new Vehicle();
        if(is_null($vehicle->where('year_id', $year)->where('make_id', $make)->where('model_id', $model)->where('engine_id', $engine)->first())) {
            $vehicle->year_id = $year;
            $vehicle->make_id = $make;
            $vehicle->model_id = $model;
            $vehicle->engine_id = $engine;
            $vehicle->save();
        }

        return $vehicle;
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
