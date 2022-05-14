<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\ShippingRequest;
use App\Models\Configs\Country;
use App\Models\Configs\Status;
use App\Models\Sales\Order;
use App\Packages\Shoppingcart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CartController extends Controller
{
    protected static $affiliate;

    public function __construct()
    {
        self::$affiliate = config('bbva.affiliate');
    }

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
        if ($cart->countItems() === 0) {
            return redirect()->route('cart');
        }

        if (!session()->has('checkout')) {
            $token = now()->addMinutes(20);
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

    /**
     * Processing and create the order
     *
     * @param ShippingRequest $request
     * @param Order $order
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function processOrder(ShippingRequest $request, Order $order, Cart $cart)
    {
        DB::beginTransaction();

        $status = Status::where('prefix', 'AWAITING_CHEQUE_PAYMENT')->where('module_name', Order::class)->first();

        try {
            $order->user_id = auth()->user()->id;
            $order->status_id = $status->id;
            $order->subtotal = $request->input('subtotal');
            $order->discount = $request->input('discount');
            $order->tax = $request->input('tax');
            $order->total = $request->input('total');
            $order->save();

            foreach ($cart->content() as $item) {
                $order->addItems($item->id, $item->qty, $item->subtotal, $item->discount, $item->tax, $item->total);
            }

            if ($status->send_email) {
                //
            }
        } catch (\Throwable$th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        $cart->destroy();

        return redirect()->route('cart.checkout', $order->id);
    }

    public function checkout(Status $status, Order $order)
    {
        return Inertia::render('Checkout/Payment', ['order' => $order]);
    }

    public function pay(Order $order, Request $request)
    {
        switch ($request) {
            case 'bbva':
                $charge = [
                    'affiliation_bbva' => self::$affiliate,
                    'amount' => $order->total,
                    'description' => '',
                    'currency' => 'MXN',
                    'order_id' => $order->id,
                    'use_3d_secure' => true,
                    'redirect_url' => '',
                    'customer' => [
                        'name' => '',
                        'last_name' => '',
                        'email' => '',
                        'phone_number' => '',
                    ]
                ];
                break;

            case 'paypal':
                # code...
                break;

            default:
                # code...
                break;
        }
    }
}
