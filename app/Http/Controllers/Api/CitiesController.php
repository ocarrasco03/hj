<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityCollection;
use App\Models\Configs\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $country Optional.
     * @param string $state Optional.
     * @return \Illuminate\Http\Response
     */
    public function __invoke($country = null, $state = null)
    {
        return new CityCollection(City::orderBy('name')
            ->when(!is_null($country), function ($query) use ($country) {
                return $query->whereHas('country', function ($query) use ($country) {
                    return $query->where('name', $country);
                });
            })
            ->when(!is_null($state), function ($query) use ($state) {
                return $query->whereHas('state', function ($query) use ($state) {
                    return $query->where('name', $state);
                });
            })
            ->get());
    }
}
