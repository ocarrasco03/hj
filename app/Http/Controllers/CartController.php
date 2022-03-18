<?php

namespace App\Http\Controllers;

use App\Packages\Shoppingcart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart)
    {
        // $i = 1;
        // $cart->add([
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        //     ['id' => Str::uuid(), 'name' => 'Product ' . $i++, 'qty' => 1, 'price' => 100.00, 'weight' => 550],
        // ]);
        return Inertia::render('Cart', [
            'cart' => $cart->content(),
            'subtotal' => $cart->subtotal(),
            'tax' => $cart->tax(),
            'discount' => $cart->discount(),
            'total' => $cart->total(),
            'count' => $cart->countItems(),
        ]);
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
    public function update(Request $request, Cart $cart)
    {
        try {
            $cart->update($request->input('id'), ['qty' => $request->input('qty'), 'name' => 'SOPORTE PARA TRANSMISION 4712']);
        } catch (\Throwable$th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }

        return response()->json(['success' => [
            'cart' => [
                'item' => [
                    'subtotal' => $cart->get($request->input('id'))->subtotal(),
                    'discount' => $cart->get($request->input('id'))->discount(),
                    'total' => $cart->get($request->input('id'))->total(),
                ],
                'subtotal' => $cart->subtotal(),
                'discount' => $cart->discount(),
                'tax' => $cart->tax(),
                'total' => $cart->total(),
            ],
        ]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart, $id)
    {
        if ($cart->countItems() <= 1) {
            $cart->destroy();
        }

        $cart->remove($id);

        return response()->json(['success' => [
            'cart' => [
                'items' => $cart->content(),
                'subtotal' => $cart->subtotal(),
                'discount' => $cart->discount(),
                'tax' => $cart->tax(),
                'total' => $cart->total(),
            ],
        ]], 200);
    }
}
