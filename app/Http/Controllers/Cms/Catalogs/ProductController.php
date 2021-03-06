<?php

namespace App\Http\Controllers\Cms\Catalogs;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImage;
use App\Http\Resources\Cms\Catalogs\ProductDetailResource;
use App\Models\Catalogs\Brand;
use App\Models\Catalogs\Product;
use App\Models\Configs\Category;
use App\Models\Vehicles\Manufacturer;
use App\Models\Vehicles\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        })->withTrashed()->paginate(15);

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
        $brands = Brand::all()->pluck('name');
        $categories = Category::allParents();
        $categories->load('children');

        return Inertia::render('Cms/Catalogs/Products/Create', [
            'brands' => $brands,
            'categories' => $categories,
            'years' => Year::orderByDesc('year')->get()->pluck('year'),
            'makes' => Manufacturer::orderBy('name', 'asc')->get()->pluck('name'),
        ]);
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
        $categories = Category::allParents();
        $categories->load('children');
        // $product->load('related', 'catalogs');

        return Inertia::render('Cms/Catalogs/Products/Show', [
            'product' => new ProductDetailResource($product),
            'brands' => $brands,
            'categories' => $categories,
            'years' => Year::orderByDesc('year')->get()->pluck('year'),
            'makes' => Manufacturer::orderBy('name', 'asc')->get()->pluck('name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalogs\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'brand' => ['required', 'string'],
            'status' => ['string', 'nullable'],
            'sku' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'cost' => ['numeric'],
            'price_wo_tax' => ['required','numeric'],
            'price' => ['required','numeric'],
            'stock' => ['numeric'],
            'notes' => ['string','nullable'],
            'attributes' => ['json','nullable'],
            'condition' => ['required', 'string'],
            'category' => ['string'],
            'subcategory' => ['string'],
            'catalogs' => ['array'],
            'related' => ['array'],
        ]);
        
        DB::beginTransaction();
        try {
            $product->sku = $request->input('sku');
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->cost = $request->input('cost');
            $product->price_wo_tax = $request->input('price_wo_tax');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->notes = $request->input('notes');
            $product->attributes = $request->input('attributes');
            $product->condition = $request->input('condition');

            $product->syncCategories([$request->input('category'),$request->input('subcategory')]);

            $product->syncApplication($request->input('catalogs'));

            $product->syncRelated($request->input('related'));

            if ($product->isDirty()) {
                $product->save();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->withErrors($th->getMessage())->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }
        DB::commit();
        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Producto actualiado correctamente']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalogs\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
        DB::commit();
        return response()->json(['success' => true, 'message' => 'El producto ' . $product->sku . ' ha sido eliminado exitosamente']);
    }

    public function restore($product)
    {
        DB::beginTransaction();
        try {
            $product = Product::withTrashed()->find($product);
            $product->restore();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        DB::commit();
        return redirect()->back();
    }

    public function upload(UploadImage $request, Product $product)
    {
        try {
            if ($request->hasFile('image')) {
                $product->addMedia($request->file('image'))->withResponsiveImages()->toMediaCollection('products');
            }
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Imagen cargada exitosamente!']]);
    }

    public function remove(Product $product, $id)
    {
        try {
            $media = Media::findByUuid($id);
            $product->deleteMedia($media->id);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Imagen eliminada exitosamente!']]);
    }

    public function export()
    {
        ini_set('max_execution_time', 0);
        return (new ProductExport)->queue('products.xlsx')->onQueue('exports');;
    }
}
