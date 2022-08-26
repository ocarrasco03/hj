<?php

namespace App\Imports\Catalogs;

use App\Models\Catalogs\Product;
use App\Models\Vehicles\Engine;
use App\Models\Vehicles\Manufacturer;
use App\Models\Vehicles\Model;
use App\Models\Vehicles\Vehicle;
use App\Models\Vehicles\Year;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ApplicationImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    use Importable;
    use Queueable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        foreach ($collection as $row) {
            $engine = null;
            $make = $this->getMake($row['make']);
            $model = $this->getModel($make->id, $row['model']);
            if ($row['lts'] !== '-' && $row['cil'] !== '-') {
                $engine = $this->getEngine($row['lts'], $row['cil'], $row['fuel'], $row['intake'], $row['valves']);
            }
            $attachments = [];
            foreach ($row as $key => $value) {
                if ($key !== 'sku' && $key !== 'brand' && $key !== 'model' && $key !== 'make' && $key !== 'notes' && $key !== 'from' && $key !== 'to' && $key !== 'lts' && $key !== 'cil') {
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
                        $this->createVehicle($year->id, $make->id, $model->id, $engine ? $engine->id : null);
                        $product->attachVehicle($year, $make, $model, $engine, $notes, $attachments);
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

    public function getEngine($liters, $cilinders, $fuel, $intake, $valves)
    {
        $engine = Engine::where('liters', $liters)->where('cilinders', $cilinders)->first();
        if (!$engine) {
            $engine = new Engine();
            $engine->display_name = $cilinders . ' ' . number_format($liters, 1);
            $engine->liters = number_format($liters, 1);
            $engine->cilinders = $cilinders;
            $engine->fuel = $fuel == '-' ? null : $fuel;
            $engine->intake = $intake == '-' ? null : $intake;
            $engine->valves = $valves == '-' ? null : $valves;
            $engine->save();
        }
        return $engine;
    }

    public function createVehicle($year, $make, $model, $engine = null)
    {
        $vehicle = new Vehicle();
        if (is_null($vehicle->where('year_id', $year)->where('make_id', $make)->where('model_id', $model)->where('engine_id', $engine)->first())) {
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
        return 100;
    }

    /**
     * @return integer
     */
    public function batchSize(): int
    {
        return 100;
    }
}
