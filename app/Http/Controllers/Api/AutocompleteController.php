<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configs\City;
use App\Models\Configs\Neighborhood;
use App\Models\Configs\ZipCode;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function cities(City $cities, Request $request, $country = null, $state = null)
    {
        $sercheable = $request->has('query') && strlen($request->input('query')) > 0;
        $term = $sercheable ? $request->input('query') : '';
        return $cities->orderBy('name')
            ->when($sercheable, function ($query) use ($term) {
                return $query->where('name', 'like', $term . '%');
            })
            ->when(!is_null($country), function ($query) use ($country) {
                return $query->whereHas('country', function ($query) use ($country) {
                    return $query->where('name', $country);
                });
            })
            ->when(!is_null($state), function ($query) use ($state) {
                return $query->whereHas('state', function ($query) use ($state) {
                    return $query->where('name', $state);
                });
            })->limit(10)
            ->get()->pluck('name');
    }

    public function zipCodes(ZipCode $zipCode, Request $request, $country, $state, $city = null)
    {
        $searcheable = $request->has('query') && strlen($request->input('query')) > 0;
        $term = $searcheable ? $request->input('query') : '';

        return $zipCode->orderBy('zip_code')
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
            })->limit(10)
            ->get()->pluck('zip_code');
    }

    public function neighborhood(Neighborhood $neighborhood, Request $request, $zip_code = null)
    {
        $searcheable = $request->has('query') && strlen($request->input('query')) > 0;
        $term = $searcheable ? $request->input('query') : '';

        return $neighborhood->when(!is_null($zip_code), function ($query) use ($zip_code) {
            return $query->whereHas('zipCode', function ($query) use ($zip_code) {
                return $query->where('zip_code', $zip_code);
            });
        })->when($searcheable, function ($query) use ($term) {
            return $query->where('name', 'like', '%' . $term . '%');
        })->limit(10)->get()->pluck('name');
    }
}
