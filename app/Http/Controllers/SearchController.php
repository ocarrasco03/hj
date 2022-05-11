<?php

namespace App\Http\Controllers;

use App\Http\Resources\Main\Home\SearchCollection;
use App\Models\Catalogs\Product;
use App\Models\Configs\Category;
use App\Models\Vehicles\Manufacturer;
use App\Models\Vehicles\Model;
use App\Models\Vehicles\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Session;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = ['total' => 0, 'data' => [], 'links' => []];
        $query = $request->input('query');
        $queries = [];
        $qTmp = ['year', 'make', 'model', 'engine', 'category', 'subcategory'];

        $year = $request->has('year') && strlen($request->input('year')) > 0 ? $request->input('year') : null;
        $make = $request->has('make') && strlen($request->input('make')) > 0 ? $request->input('make') : null;
        $model = $request->has('model') && strlen($request->input('model')) > 0 ? $request->input('model') : null;
        $engine = $request->has('engine') && strlen($request->input('engine')) > 0 ? $request->input('engine') : null;
        $category = $request->has('category') && strlen($request->input('category')) > 0 ? $request->input('category') : null;
        $subcategory = $request->has('subcategory') && strlen($request->input('subcategory')) > 0 ? $request->input('subcategory') : null;

        if (empty($request->all())) {
            return Inertia::render('Catalogs/Search', ['products' => $products]);
        }

        if ($request->has('query') && strlen($request->input('query')) > 0) {
            $this->validateSessionSearchApplication();
            $products = Product::search($query)->paginate(10);
            $products->appends(['query' => $request->input('query')]);
        } else {
            $this->validateSessionSearchApplication($request->all());
            $products = Product::applicationSearch($year, $make, $model, $engine, $category, $subcategory)
                ->paginate(10);

            foreach ($qTmp as $value) {
                if ($request->has($value) && strlen($request->input($value)) > 0) {
                    $queries[$value] = $request->input($value);
                }
            }

            $products->appends($queries);
        }

        return Inertia::render('Catalogs/Search', ['products' => new SearchCollection($products)]);
    }

    /**
     * Set a new search session parameters
     *
     * @param array $values
     * @return \Session
     */
    public function validateSessionSearchApplication(array $values = [])
    {
        $search = Session::get('search');

        foreach ($search as $key => $value) {
            if (key_exists($key, $values)) {
                if ($value !== $values[$key]) {
                    $search[$key] = $values[$key];
                }
            } else {
                $search[$key] = null;
            }
        }

        return Session::put('search', $search);
    }

}
