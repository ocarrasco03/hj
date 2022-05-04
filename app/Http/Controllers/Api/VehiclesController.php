<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicles\Manufacturer;
use App\Models\Vehicles\Model;
use App\Models\Vehicles\Year;

class VehiclesController extends Controller
{
    /**
     * Get all years
     *
     * @return \App\Models\Vehicles\Year
     */
    public function years()
    {
        return Year::orderByDesc('year')->get()->pluck('year');
    }

    /**
     * Get all vehicle makes on the database with models
     *
     * @return \App\Models\Vehicles\Manufacturer
     */
    public function makes()
    {
        return Manufacturer::orderBy('name')->with('models')->get();
    }

    /**
     * Gel all vehicle makes only names
     *
     * @return \App\Models\Vehicles\Manufacturer
     */
    public function makeNames()
    {
        return Manufacturer::orderBy('name')->get()->pluck('name');
    }

    /**
     * Get all model names
     *
     * @return \App\Models\Vehicles\Model
     */
    public function modelNames()
    {
        return Model::orderBy('name')->get()->pluck('name');
    }

    /**
     * Get all model names by make
     *
     * @param strign $make
     * @return \App\Models\Vehicles\Model
     */
    public function modelNamesByMake($make)
    {
        return Model::orderBy('name')
            ->whereHas('makes', function ($query) use ($make) {
                return $query->where('name', $make);
            })
            ->get()
            ->pluck('name');
    }

    /**
     * Get all models by make and year
     *
     * @param string $make
     * @param string|integer $year
     * @return \App\Models\Vehicles\Model
     */
    public function modelNamesByAppliaction($make, $year)
    {
        return Model::orderBy('name')
            ->whereHas('makes', function ($query) use ($make) {
                return $query->where('name', $make);
            })
            ->whereHas('years', function ($query) use ($year) {
                return $query->where('year', $year);
            })
            ->get()
            ->pluck('name');
    }
}
