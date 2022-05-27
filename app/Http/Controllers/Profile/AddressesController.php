<?php

namespace App\Http\Controllers\Profile;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Configs\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\AddressRequest;
use App\Http\Resources\Main\Profile\AddressCollection;

class AddressesController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Profile/Addresses', [
            'addresses' => new AddressCollection(auth()->user()->addresses),
            'countries' => Country::all()->pluck('name'),
        ]);
    }

    public function store(AddressRequest $request)
    {
        $type = 'both';

        if (count(auth()->user()->addresses) > 0) {
            $type = null;
        }

        auth()
            ->user()
            ->addAddress($request->country, $request->state, $request->city, $request->street, $request->zip_code, $request->neighborhood, $request->ext_no, $request->int_no, $request->notes, $type);

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Dirección añadida exitosamente!']]);
    }

    public function setAddress($id, $type = 'billing')
    {
        if ($type === 'shipping') {
            auth()->user()->setShippingAddress($id);
        } else {
            auth()->user()->setBillingAddress($id);
        }

        return redirect()->back();
    }

}
