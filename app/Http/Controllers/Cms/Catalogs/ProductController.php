<?php

namespace App\Http\Controllers\Cms\Catalogs;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Catalogs\Brand;
use App\Models\Catalogs\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $products)
    {
        $searcheable = $request->has('query') && strlen($request->input('query')) > 0;
        $search = $request->has('query') && strlen($request->input('query')) > 0 ? $request->input('query') : '';

        $products = $products->when($searcheable, function ($query) use ($search) {
            return $query->crawler($search);
        })->paginate(15);

        if ($searcheable) {
            $products->appends(['query' => $request->input('query')]);
        }

        return Inertia::render('Cms/Catalogs/Products/Products', ['products' => $products]);
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
     * @param  \App\Models\Catalogs\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $brands = Brand::all()->pluck('name');
        return Inertia::render('Cms/Catalogs/Products/Show', ['product' => $product, 'brands' => $brands]);
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
}
