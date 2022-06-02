<?php

namespace App\Http\Controllers\Cms\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\Customers\CustomerCollection;
use App\Http\Resources\Cms\Customers\CustomerDetailResource;
use App\Http\Resources\Cms\Sales\OrderCollection;
use App\Models\Sales\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $users)
    {
        $searcheable = $request->has('query') && strlen($request->input('query')) > 0;
        $search = $request->has('query') && strlen($request->input('query')) > 0 ? $request->input('query') : '';
        $users = $users->when($searcheable, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', $search . '%');
        })->withTrashed()->paginate(15);

        if ($searcheable) {
            $users->appends(['query' => $request->input('query')]);
        }

        return Inertia::render('Cms/Customers/Customer/Index', ['users' => new CustomerCollection($users)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customer, Order $orders)
    {
        return Inertia::render('Cms/Customers/Customer/Show', [
            'customer' => new CustomerDetailResource(User::withTrashed()->findOrFail($customer)),
            'orders' => new OrderCollection($orders->whereHas('user', function ($query) use ($customer) {
                    return $query->where('id', $customer);
                })->paginate(20)),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        DB::beginTransaction();
        try {
            $customer->delete();
        } catch (\Throwable$th) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
        DB::commit();
        return response()->json(['success' => true, 'message' => 'El usuario ' . $customer->firstname . 'ha sido eliminado exitosamente']);
    }

    /**
     * Restore the specified from storage.
     *
     * @param int $customer
     * @return \Illuminate\Http\Response
     */
    public function restore($customer)
    {
        DB::beginTransaction();
        try {
            $customer = User::onlyTrashed()->find($customer);
            $customer->restore();
        } catch (\Throwable$th) {
            DB::rollBack();
            return redirect()->back()->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }
        DB::commit();
        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'El usuario ' . $customer->firstname . 'ha sido restaurado exitosamente']]);
    }
}
