<?php

namespace App\Http\Controllers;

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

        if (empty($request->all())) {
            return Inertia::render('Catalogs/Search', ['products' => $products]);
        }

        if (!is_null($query)) {
            $this->validateSessionSearchApplication();
            $products = Product::search($query)->paginate(10);
            $products->appends(['query' => $request->input('query')]);
        } else {
            $this->validateSessionSearchApplication($request->all());
            $products = Product::withCount(['ratings as averageRating' => function ($query) {
                $query->select(DB::raw('avg(rating)'));
            }])
                ->when(!is_null($request->input('year')), function ($query) use ($request) {
                    return $query->whereHas('catalogs', function ($query) use ($request) {
                        return $query->whereHas('year', function ($query) use ($request) {
                            return $query->where('year', $request->input('year'));
                        });
                    });
                })
                ->when(!is_null($request->input('make')), function ($query) use ($request) {
                    return $query->whereHas('catalogs', function ($query) use ($request) {
                        return $query->whereHas('make', function ($query) use ($request) {
                            return $query->where('name', $request->input('make'));
                        });
                    });
                })
                ->when(!is_null($request->input('model')), function ($query) use ($request) {
                    return $query->whereHas('catalogs', function ($query) use ($request) {
                        return $query->whereHas('model', function ($query) use ($request) {
                            return $query->where('name', $request->input('model'));
                        });
                    });
                })
                ->when(!is_null($request->input('make')), function ($query) use ($request) {
                    return $query->whereHas('catalogs', function ($query) use ($request) {
                        return $query->whereHas('make', function ($query) use ($request) {
                            return $query->where('name', $request->input('make'));
                        });
                    });
                })
                ->when(!is_null($request->input('category')), function ($query) use ($request) {
                    return $query->whereHas('categories', function ($query) use ($request) {
                        return $query->where('name', $request->input('category'))->where('parent', 0);
                    });
                })
                ->when(!is_null($request->input('subcategory')), function ($query) use ($request) {
                    return $query->whereHas('categories', function ($query) use ($request) {
                        $parent = Category::where('name', $request->input('category'))
                            ->where('parent', 0)
                            ->first();

                        return $query->where('name', $request->input('subcategory'))->where('parent', $parent->id);
                    });
                })
                ->paginate(10);

            foreach ($qTmp as $value) {
                if (!is_null($request->input($value))) {
                    $queries[$value] = $request->input($value);
                }
            }

            $products->appends($queries);
        }

        return Inertia::render('Catalogs/Search', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getYears()
    {
        $years = Year::select('year')->orderBy('year', 'desc')->get();
        return $years;
    }

    public function getMakes()
    {
        $makes = Manufacturer::select('name')->orderBy('name', 'asc')->get();
        return $makes;
    }

    public function getModels($year, $make)
    {

        $models = Model::select('name')
            ->whereHas('makes', function ($query) use ($make) {
                return $query->where('name', $make);
            })
            ->whereHas('years', function ($query) use ($year) {
                return $query->where('year', $year);
            })
            ->orderBy('name', 'asc')->get();

        return $models;
    }

    public function getEngines()
    {
        $years = Year::select('year')->orderBy('year', 'desc')->get();
        return $years;
    }

    public function getCategories()
    {
        $categories = Category::where('parent', 0)->orderBy('name', 'asc')->get();
        return $categories;
    }

    public function getSubCategories($parent)
    {
        $parent = Category::where('name', $parent)->where('parent', 0)->first();
        $subcategories = Category::where('parent', $parent->id)->orderBy('name', 'asc')->get();
        return $subcategories;
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
