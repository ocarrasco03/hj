<?php

namespace App\Http\Controllers;

use App\Http\Resources\Main\Profile\OrderResource;
use App\Models\Catalogs\Product;
use App\Models\Configs\Status;
use App\Models\Sales\Order;
use App\Models\Sales\Transaction;
use App\Models\User;
use App\Packages\BBVA\BBVA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    protected $affiliate;

    private $errors;

    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const REFUNDED = 'refunded';
    const CHARGE_PENDING = 'charge_pending';
    const CANCELLED = 'cancelled';
    const FAILED = 'failed';

    public function __construct()
    {
        $this->affiliate = config('bbva.affiliate');
    }

    public function executeBbvaPayment(Order $order, Request $request, Transaction $transaction)
    {
        $charge = [
            'affiliation_bbva' => $this->affiliate,
            'amount' => $order->total,
            'description' => 'Compra en HJ ACCO Autopartes SA de CV con folio ' . $order->id,
            // 'description' => "SKIP Payment MSI",
            // 'payment_plan' => [
            //     'payments' => 6,
            //     'payments_type' => 'WITHOUT_INTEREST',
            //     'deferred_months' => 3,
            // ],
            'currency' => 'MXN',
            'order_id' => $order->id,
            'use_3d_secure' => true,
            'redirect_url' => route('checkout.charge', ['order' => $order->id]),
            'customer' => [
                'name' => $order->user->firstname,
                'last_name' => $order->user->lastname,
                'email' => $order->user->email,
                'phone_number' => $order->user->phone,
            ],
        ];

        try {
            $bbva = BBVA::charges($charge);

            $transaction->ip_address = $request->ip();
            $transaction->order_id = $order->id;
            $transaction->type = 'capture';
            $transaction->payment_provider = 'bbva';
            $transaction->content = json_encode([
                'request' => $charge,
                'response' => $bbva,
            ]);
            $transaction->created_at = now();
            $transaction->save();

            if ($bbva['payment_method']['type'] == 'redirect') {
                return Inertia::location($bbva['payment_method']['url']);
            }

        } catch (\Throwable$th) {
            // throw $th;
            return redirect()->back()->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }

        return $bbva->charges->create($charge);
    }

    /**
     * Listen the bank response for the transaction was successfull or failed
     *
     * @param Request $request
     * @param Order $order
     * @param Status $status
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function charge(Request $request, Order $order, Status $status, Transaction $transaction)
    {
        $provider = $request->has('provider') ? $request->input('provider') : 'bbva';

        if (!$request->has('provider')) {
            $bbva = BBVA::getCharge($request->input('id'));
            switch ($bbva['status']) {
                case self::COMPLETED:
                    $status = $status->where('prefix', 'PAYMENT_ACCEPTED')->first();
                    break;
                case self::IN_PROGRESS:
                    $status = $status->where('prefix', 'PREPARATION_IN_PROGRESS')->first();
                    break;
                case self::FAILED:
                    $status = $status->where('prefix', 'PAYMENT_ERROR')->first();
                    break;
                default:
                    $status = $status->where('prefix', 'PAYMENT_ERROR')->first();
                    break;
            }

            $transaction_status = $bbva['status'];
            $content = json_encode($bbva);
        } else {
            switch ($request->input('status')) {
                case self::COMPLETED:
                    $status = $status->where('prefix', 'PAYMENT_ACCEPTED')->first();
                    break;
                case self::IN_PROGRESS:
                    $status = $status->where('prefix', 'PREPARATION_IN_PROGRESS')->first();
                    break;
                case self::FAILED:
                    $status = $status->where('prefix', 'PAYMENT_ERROR')->first();
                    break;
                default:
                    $status = $status->where('prefix', 'PAYMENT_ERROR')->first();
                    break;
            }
            $transaction_status = $request->input('status');
            $content = $request->input('response');
        }

        $transaction->ip_address = $request->ip();
        $transaction->order_id = $order->id;
        $transaction->type = 'charge';
        $transaction->payment_provider = $provider;
        $transaction->content = $content;
        $transaction->created_at = now();
        $transaction->save();

        if ($transaction_status == 'completed') {
            $order->update([
                'status_id' => $status->id,
                'payment_provider' => $provider,
                'transaction_id' => $request->input('id')
            ]);

        } else {
            $order->update([
                'status_id' => $status->id,
            ]);

            switch ($provider) {
                case 'bbva':
                    $this->errors = $bbva['error_message'];
                    break;

                default:
                    $response = json_decode($request->input('response'));
                    $this->errors = $response->body->details['0']->description;
                    break;
            }

            return redirect()->route('cart.checkout', ['order' => $order->id])->with(['toast' => ['type' => 'error', 'message' => $this->errors]])->withErrors($this->errors);
        }

        return redirect()->route('home');
    }

    public function chargePayPal(Request $request, Order $order, Status $status, Transaction $transaction)
    {
        switch ($request->input('status')) {
            case self::COMPLETED:
                $status = $status->where('prefix', 'PAYMENT_ACCEPTED')->first();
                break;
            case self::IN_PROGRESS:
                $status = $status->where('prefix', 'PREPARATION_IN_PROGRESS')->first();
                break;
            case self::FAILED:
                $status = $status->where('prefix', 'PAYMENT_ERROR')->first();
                break;
            default:
                $status = $status->where('prefix', 'PAYMENT_ERROR')->first();
                break;
        }

        $transaction->ip_address = $request->ip();
        $transaction->order_id = $order->id;
        $transaction->type = 'charge';
        $transaction->payment_provider = 'bbva';
        $transaction->content = json_encode($request->all());
        $transaction->created_at = now();
        $transaction->save();
    }

    public function refund(Order $order, Status $status)
    {
        $status = $status->where('prefix', 'REFUND')->first();

        dd($this->getOrderStatusPrefix('completed'));

        try {
            switch ($order->payment_provider) {
                case 'bbva':
                    $charge = BBVA::getCharge($order->transaction_id);
                    $refund = [
                        'description' => "Devoluci??n de orden " . $order->id,
                        'amount' => number_format($order->total, 2, ""),
                    ];
                    if (!key_exists('refunds', $charge)) {
                        $transaction = BBVA::refund($order->transaction_id, $refund);
                        if ($transaction['refunds'][0]['status'] === self::COMPLETED) {
                            $order->status_id = $status->id;
                            if ($order->isDirty()) {
                                $order->save();
                            }
                        }
                    }
                    break;
                case 'paypal':
                    $refund = [
                        'note_to_payer' => "Devoluci??n de orden " . $order->id,
                        'amount' => [
                            'value' => number_format($order->total, 2, ""),
                            'currency_code' => 'MXN',
                        ],
                        'invoice_id' => $order->id,
                    ];

                    $paypal = Http::post("https://api-m.sandbox.paypal.com/v2/payments/captures/" . $order->transaction_id . "/refund", $refund);

                    if ($paypal['status'] != "COMPLETED") {
                        throw new \Exception();
                    }

                    $order->status_id = $status->id;
                    if ($order->isDirty()) {
                        $order->save();
                    }
                    break;
            }
        } catch (\Throwable$th) {
            return redirect()->back()->with(['toast' => ['type' => 'error', 'message' => 'Lo sentimos no se pudo hacer la devolucion de tu orden']]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Tu orden ha sido reembolsada exitosamente tu pago. Tu banco puede tardar hasta 15 d??as en finalizar la transacci??n.']]);
    }

    public function paid(Order $order)
    {
        return Inertia::render('Checkout/Accepted', [
            'order' => new OrderResource($order),
        ]);
    }

    /**
     * Cancel a placed order
     *
     * @param Order $order
     * @param Status $status
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order, Status $status)
    {

        $status = $status->where('prefix', 'CANCELED')->first();

        $order->status_id = $status->id;

        if ($order->isDirty()) {
            $order->save();
            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Orden cancelada exitosamente']]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'error', 'message' => 'Lo sentimos no se pudo cancelar la orden']]);
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
     * Get the requested status of the order.
     *
     * @param string $status
     * @return \App\Models\Configs\Status
     */
    private function getOrderStatusPrefix($status)
    {
        switch ($status) {
            case 'in_progress':
                return Status::where('prefix', 'PREPARATION_IN_PROGRESS')
                    ->where('module_name', Order::class)->pluck('prefix')->first();
                break;
            case 'completed':
                return Status::where('prefix', 'PAYMENT_ACCEPTED')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
                break;
            case 'charge_pending':
                return Status::where('prefix', 'AWAITING_CHEQUE_PAYMENT')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
                break;
            case 'delivered':
                return Status::where('prefix', 'DELIVERED')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
                break;
            case 'shipped':
                return Status::where('prefix', 'SHIPPED')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
                break;
            case 'cancelled':
                return Status::where('prefix', 'CANCELED')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
                break;
            case 'failed':
                return Status::where('prefix', 'PAYMENT_ERROR')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
                break;
            case 'refunded':
                return Status::where('prefix', 'REFUND')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
                break;
            default:
                return Status::where('prefix', 'PAYMENT_ERROR')
                    ->where('module_name', Order::class)->prefix('prefix')->first();
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
