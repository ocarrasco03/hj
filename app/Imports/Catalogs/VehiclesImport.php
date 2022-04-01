<?php

namespace App\Imports\Catalogs;

use App\Models\Vehicles\Year;
use App\Models\Vehicles\Model;
use Illuminate\Support\Collection;
use App\Models\Vehicles\Manufacturer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class VehiclesImport implements ToCollection, WithHeadingRow, WithChunkReading, WithProgressBar, WithBatchInserts, ShouldQueue
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

            if ($row['from'] !== 'TODOS') {
                $years = [];
                for ($i = $row['from']; $i <= $row['to']; $i++) {
                    $year = $this->getYear($i);
                    $years[] = $year->id;
                }
                $model->storeYear($years);
            }
        }
    }

    public function chunkSize(): int
    {
        return 10;
    }

    public function batchSize(): int
    {
        return 10;
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

}
