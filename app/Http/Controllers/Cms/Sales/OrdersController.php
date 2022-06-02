<?php

namespace App\Http\Controllers\Cms\Sales;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\Sales\OrderResource;
use App\Models\Sales\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $orders)
    {
        $statusable = $request->has('status') && strlen($request['status']) > 0;
        $searcheable = $request->has('query') && strlen($request['query']) > 0;

        $orders = $orders->orderByDesc('updated_at')->when($statusable, function ($query) use ($request) {
            $status = strtoupper($request->input('status'));
            return $query->whereHas('status', function ($query) use ($status) {
                return $query->where('prefix', $status);
            });
        })->when($searcheable, function ($query) use ($request) {
            return $query->search($request->input('query'));
        })->paginate(15);

        if ($statusable) {
            $orders->appends(['status' => $request->input('status')]);
        }

        if ($searcheable) {
            $orders->appends(['query' => $request->input('query')]);
        }

        return Inertia::render('Cms/Sales/Orders/Order', [
            'orders' => $orders,
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
     * @param  \App\Models\Sales\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return Inertia::render('Cms/Sales/Orders/Show', ['order' => new OrderResource($order)]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
