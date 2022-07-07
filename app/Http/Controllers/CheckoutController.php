<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Sales\Order;
use App\Packages\BBVA\BBVA;
use Illuminate\Http\Request;
use App\Models\Configs\Status;
use App\Models\Catalogs\Product;
use App\Jobs\Orders\NotifyUserPaymentFailed;
use App\Jobs\Orders\NotifyUserPaymentAccepted;

class CheckoutController extends Controller
{
    protected $affiliate;

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

    public function executeBbvaPayment(Order $order, Request $request)
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

            if ($bbva['payment_method']['type'] == 'redirect') {
                return Inertia::location($bbva['payment_method']['url']);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }

        return $bbva->charges->create($charge);
    }

    public function charge(Request $request, Order $order, Status $status)
    {
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

        if ($bbva['status'] == 'completed') {
            $order->update([
                'status_id' => $status->id,
            ]);

        } else {
            $order->update([
                'status_id' => $status->id,
            ]);

            return redirect()->route('cart.checkout', ['order' => $order->id])->with(['toast' => ['type' => 'error', 'message' => $bbva['error_message']]])->withErrors($bbva['error_message']);
        }

        return redirect()->route('home');
    }

    public function cancel(Order $order, Status $status)
    {

        $status = $status->where('prefix', 'CANCELED')->first();

        $order->status_id = $status->id;

        if ($order->isDirty()) {
            $order->save();
            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Orden cancelada exitosamente']]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'danger', 'message' => 'Lo sentimos no se pudo cancelar la orden']]);
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
