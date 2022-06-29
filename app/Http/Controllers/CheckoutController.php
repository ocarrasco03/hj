<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sales\Order;
use App\Packages\BBVA\BBVA;
use Illuminate\Http\Request;
use App\Models\Configs\Status;

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

    public function executeBbvaPayment(Order $order)
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

        } catch (\Throwable$th) {
            //throw $th;
            return redirect()->back()->with(['toast' => ['type' => 'danger', 'message' => $th->getMessage()]]);
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
            case self::REFUNDED:
                $status = $status->where('prefix', 'REFUND')->first();
                break;
            case self::CANCELLED:
                $status = $status->where('prefix', 'CANCELED')->first();
                break;
            case self::IN_PROGRESS:
                $status = $status->where('prefix', 'PREPARATION_IN_PROGRESS')->first();
                break;
            default:
                $status = $status->where('prefix', 'PAYMENT_ERROR')->first();
                break;
        }

        if ($bbva['status'] == 'completed') {
            $order->update([
                // 'payment' => 'bbva',
                'status_id' => $status->id,
            ]);
        } else {
            return redirect()->back()->with(['toast' => ['type' => 'danger', 'message' => $bbva['error_message']]]);
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
}
