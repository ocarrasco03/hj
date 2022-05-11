<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Catalogs\Product;
use App\Models\Configs\Country;
use App\Models\Sales\Order;
use App\Packages\Shoppingcart\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart)
    {
        return Inertia::render('Cart', [
            'cart' => $cart->content(),
            'subtotal' => $cart->subtotalFloat(),
            'tax' => $cart->taxFloat(),
            'discount' => $cart->discountFloat(),
            'total' => $cart->totalFloat(),
            'count' => $cart->countItems(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => ['required', 'string'],
            'qty' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return Redirect::route('home')->with(['toast' => ['type' => 'success', 'message' => 'Los parametros son incorrectos']]);
        }

        $cart->add(
            $request->input('id'),
            $request->input('name'),
            $request->input('qty'),
            $request->input('price'),
            0,
            $request->input('options'),
        );

        return Redirect::back()->with(['toast' => ['type' => 'success', 'message' => 'Producto añadido']]);
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
            $cart->update($request->input('id'), ['qty' => $request->input('qty')]);
        } catch (\Throwable$th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }

        return response()->json(['success' => [
            'cart' => [
                'item' => [
                    'subtotal' => $request->input('qty') > 0 ? $cart->get($request->input('id'))->subtotal() : null,
                    'discount' => $request->input('qty') > 0 ? $cart->get($request->input('id'))->discount() : null,
                    'total' => $request->input('qty') > 0 ? $cart->get($request->input('id'))->total() : null,
                ],
                'subtotal' => $cart->subtotalFloat(),
                'discount' => $cart->discountFloat(),
                'tax' => $cart->taxFloat(),
                'total' => $cart->totalFloat(),
                'count' => $cart->countItems(),
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
        try {
            if ($cart->countItems() <= 1) {
                $cart->destroy();
            }

            $cart->update($id, ['qty' => 0]);
        } catch (\Throwable$th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }

        return response()->json(['success' => [
            'cart' => [
                'items' => $cart->content(),
                'subtotal' => $cart->subtotalFloat(),
                'discount' => $cart->discountFloat(),
                'tax' => $cart->taxFloat(),
                'total' => $cart->totalFloat(),
            ],
        ]], 200);
    }

    public function shipping(Cart $cart)
    {
        if (!session()->has('checkout')) {
            $token = now()->addMinutes(10);
            session()->put(['checkout' => $token]);
        }

        foreach (Session::get('checkout') as $value) {
            if ($value < now()) {
                session()->forget('checkout');
                return redirect()->route('cart')->with(['toast' => ['type' => 'error', 'message' => 'El token ha expirado']]);
            }
        }

        return Inertia::render('Checkout/Shipping', [
            'countries' => Country::all()->pluck('name'),
            'items' => $cart->content(),
            'tax' => $cart->taxFloat(),
            'subtotal' => $cart->subtotalFloat(),
            'discount' => $cart->discountFloat(),
            'total' => $cart->totalFloat(),
        ]);
    }

    public function processOrder(Request $request)
    {
        return redirect()->route('cart.process.order');
    }

    public function checkout(Order $order)
    {
        return Inertia::render('Checkout/Payment');
    }
}
