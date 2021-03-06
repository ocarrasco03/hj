<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Configs\CategoryCollection;
use App\Http\Resources\Api\Vehicles\MakeCollection;
use App\Http\Resources\Api\Vehicles\ModelCollection;
use App\Http\Resources\Api\Vehicles\YearCollection;
use App\Models\Configs\Category;
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
        return new YearCollection(Year::orderByDesc('year')->get());
    }

    /**
     * Get all vehicle makes on the database with models
     *
     * @return \App\Models\Vehicles\Manufacturer
     */
    public function makes()
    {
        return new MakeCollection(Manufacturer::orderBy('name')->get());
    }

    /**
     * Get all model names
     *
     * @param string $make Optional.
     * @param string $year Optional.
     * @return \App\Models\Vehicles\Model
     */
    public function models($make = null, $year = null)
    {
        return new ModelCollection(Model::orderBy('name')
            ->when(!is_null($make), function ($query) use ($make) {
                return $query->whereHas('make', function ($query) use ($make) {
                    return $query->where('name', $make);
                });
            })
            ->when(!is_null($year), function ($query) use ($year) {
                return $query->whereHas('year', function ($query) use ($year) {
                    return $query->where('year', $year);
                });
            })
            ->get());
    }

    /**
     * Get all categories with subcategories
     *
     * @return \App\Models\Configs\Category
     */
    public function categories($category = null)
    {
        return new CategoryCollection(Category::orderBy('name')
            ->when(!is_null($category), function ($query) use ($category) {
                return $query->where('name', $category);
            })
            ->when(is_null($category), function ($query) {
                return $query->where('parent_id', null);
            })->get());
    }
}
