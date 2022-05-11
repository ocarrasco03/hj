<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NeighnorhoodCollection;
use App\Models\Configs\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string|int $zip_code
     * @return \Illuminate\Http\Response
     */
    public function __invoke($zip_code)
    {
        return new NeighnorhoodCollection(Neighborhood::orderBy('name')
            ->whereHas('zipCode', function ($query) use ($zip_code) {
                return $query->where('zip_code', $zip_code);
            })->get());
    }
}
