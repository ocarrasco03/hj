<?php

namespace App\Http\Controllers\Profile;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Configs\Country;
use App\Http\Controllers\Controller;

class AddressesController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Profile/Addresses', [
            'addresses' => [],
            'countries' => Country::all()->pluck('name'),
        ]);
    }

}
