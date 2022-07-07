<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Main\Profile\OrderCollection;
use App\Models\Sales\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public function index(Order $orders)
    {
        return Inertia::render('Profile/Orders', [
            'orders' => new OrderCollection($orders->where('user_id',auth()->user()->id)->paginate(15))
        ]);
    }
}
