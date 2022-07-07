<?php

namespace App\Http\Controllers;

use Exception;
use Notification;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Sales\Order;
use App\Packages\BBVA\BBVA;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configs\Status;
use App\Models\Configs\Country;
use App\Models\Catalogs\Product;
use Illuminate\Support\Facades\DB;
use App\Packages\Shoppingcart\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Jobs\Orders\NotifyUserOrderPlaced;
use App\Notifications\Orders\OrderCreated;
use App\Http\Requests\Cart\ShippingRequest;
use App\Jobs\Orders\NotifyUserPaymentFailed;
use App\Jobs\Orders\NotifyUserPaymentAccepted;
use App\Http\Resources\Cms\Sales\OrderResource;
use App\Http\Resources\Main\Profile\UserResource;
use App\Http\Resources\Main\Profile\AddressCollection;

class CartController extends Controller
{
    protected static $affiliate;

    /**
     * @var App\Packages\Shoppingcart\Cart
     */
    private $cart;

    public function __construct(Cart $cart)
    {
        self::$affiliate = config('bbva.affiliate');
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Cart', [
            'cart' => $this->cart->content(),
            'subtotal' => $this->cart->subtotalFloat(),
            'tax' => $this->cart->taxFloat(),
            'discount' => $this->cart->discountFloat(),
            'total' => $this->cart->totalFloat(),
            'count' => $this->cart->countItems(),
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

    /**
     * Render view for shipping form
     *
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
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
            'user' => new UserResource(auth()->user()),
            'addresses' => new AddressCollection(auth()->user()->addresses),
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

        $status = $this->getOrderStatus('charge_pending');

        try {
            $order->user_id = auth()->user()->id;
            $order->status_id = $status->id;
            $order->address_id = $request->input('address');
            $order->subtotal = $request->input('subtotal');
            $order->discount = $request->input('discount');
            $order->tax = $request->input('tax');
            $order->total = $request->input('total');
            $order->save();

            foreach ($cart->content() as $item) {
                $order->addItems($item->id, $item->qty, $item->subtotal, $item->discount, $item->tax, $item->total);
            }

            $this->updateStocks($cart->content());

            session()->forget('checkout');

            if ($status->send_email) {
                auth()->user()->notify(new OrderCreated($order, auth()->user()));
            }
        } catch (\Throwable$th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->withErrors($th->getMessage());
        }

        DB::commit();
        $cart->destroy();

        return redirect()->route('cart.checkout', $order->id);
    }

    /**
     * Payment process view
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function checkout(Order $order)
    {
        $charge_pending = $this->getOrderStatus('charge_pending');
        $in_progress = $this->getOrderStatus('in_progress');
        $failed = $this->getOrderStatus('failed');

        if ($order->status_id !== $failed->id && $order->status_id !== $charge_pending->id && $order->status_id !== $in_progress->id) {
            return redirect()->route('profile.orders');
        }

        Inertia::share('paypal', env('PAYPAL_CLIENT_ID'));

        return Inertia::render('Checkout/Payment', ['order' => new OrderResource($order)]);
    }

    /**
     * Get the requested status of the order.
     *
     * @param string $status
     * @return \App\Models\Configs\Status
     */
    private function getOrderStatus($status)
    {
        switch ($status) {
            case 'in_progress':
                return Status::where('prefix', 'PREPARATION_IN_PROGRESS')
                    ->where('module_name', Order::class)->first();
                break;
            case 'completed':
                return Status::where('prefix', 'PAYMENT_ACCEPTED')
                    ->where('module_name', Order::class)->first();
                break;
            case 'charge_pending':
                return Status::where('prefix', 'AWAITING_CHEQUE_PAYMENT')
                    ->where('module_name', Order::class)->first();
                break;
            case 'delivered':
                return Status::where('prefix', 'DELIVERED')
                    ->where('module_name', Order::class)->first();
                break;
            case 'shipped':
                return Status::where('prefix', 'SHIPPED')
                    ->where('module_name', Order::class)->first();
                break;
            case 'cancelled':
                return Status::where('prefix', 'CANCELED')
                    ->where('module_name', Order::class)->first();
                break;
            case 'failed':
                return Status::where('prefix', 'PAYMENT_ERROR')
                    ->where('module_name', Order::class)->first();
                break;
            case 'refunded':
                return Status::where('prefix', 'REFUND')
                    ->where('module_name', Order::class)->first();
                break;
            default:
                return Status::where('prefix', 'PAYMENT_ERROR')
                    ->where('module_name', Order::class)->first();
                break;
        }
    }

    /**
     * Update product stocks after create an order or
     * cancel an order.
     *
     * @param array|object $items
     * @param string $mode Default 'reduce'. Accepts 'reduce', 'increment'.
     */
    private function updateStocks($items, $mode = 'reduce')
    {
        foreach ($items as $item) {
            $product = Product::find($item->id);

            switch ($mode) {
                case 'reduce':
                    $product->stock = $product->stock - $item->qty;

                    if ($product->stock < 0) {
                        $product->stock = 0;
                    }

                    if ($product->isDirty()) {
                        $product->save();
                    }
                    break;
                case 'increment':
                    $product->stock = $product->stock + $item->quantity;

                    if ($product->isDirty()) {
                        $product->save();
                    }
                    break;
            }
        }
    }
}
