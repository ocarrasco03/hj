<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\StateCollection;
use App\Models\Configs\State;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $country Optional
     * @return \Illuminate\Http\Response
     */
    public function __invoke($country = null)
    {
        return new StateCollection(State::orderBy('name')
                ->when(!is_null($country), function ($query) use ($country) {
                    return $query->whereHas('country', function ($query) use ($country) {
                        return $query->where('name', $country);
                    });
                })->get());
    }
}
