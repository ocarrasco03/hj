<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ZipCodeCollection;
use App\Models\Configs\ZipCode;
use Illuminate\Http\Request;

class ZipCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $country, $state, $city = null)
    {
        $searcheable = $request->has('query') && strlen($request->input('query')) > 0;
        $term = $searcheable ? $request->input('query') : '';

        return new ZipCodeCollection(ZipCode::orderBy('zip_code')
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
            ->when(!is_null($city), function ($query) use ($city) {
                return $query->whereHas('city', function ($query) use ($city) {
                    return $query->where('name', $city);
                });
            })
            ->when($searcheable, function ($query) use ($term) {
                return $query->where('zip_code', 'like', $term . '%');
            })
            ->get());
    }
}
