<?php

namespace App\Http\Controllers;

use Str;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Catalogs\Product;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Http\Resources\Main\Home\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = new ProductResource(Product::where('slug', $slug)->firstOrFail());
        $descriptionMeta = $product->sku . ' ' . strtolower($product->name) . ' ' . $product->brand->name . '. Compara Precios y Compra ' . strtolower($product->name) . 'Online en HJAutopartes.com.mx. Distribuidor Autorizado' . $product->brand->name . '. Con envios a toda la republica mexicana.';
        $media = $product->getMedia();

        SEOMeta::setDescription($descriptionMeta);
        SEOMeta::setCanonical(route('product.show', ['slug' => $slug]));

        OpenGraph::setDescription($descriptionMeta);
        OpenGraph::setTitle($product->sku . ' ' . $product->name);
        OpenGraph::setUrl(route('product.show', ['slug' => $slug]));
        // OpenGraph::addProperty('type', 'articles');

        JsonLd::setTitle($product->sku . ' ' . $product->name);
        JsonLd::setDescription($descriptionMeta);
        JsonLd::addImage($product->getFirstMediaUrl());

        foreach ($media as $image) {
            OpenGraph::addImage($image->getFullUrl());
        }

        return Inertia::render('Catalogs/Product', [
            'product' => $product
        ]);
    }
}
