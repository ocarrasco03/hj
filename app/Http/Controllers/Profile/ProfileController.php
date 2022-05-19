<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\Sales\OrderCollection;
use App\Http\Resources\Main\Profile\UserResource;
use App\Models\Sales\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function __invoke(Order $orders)
    {
        return Inertia::render('Profile/Profile', [
            'user' => new UserResource(auth()->user()),
            'orders' => new OrderCollection($orders->where('user_id', auth()->user()->id)->take(5)->get())
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
        ]);

        $user = User::find(auth()->user()->id);

        if ($request->email !== $user->email) {
            $request->validate([
                'email' => ['required', 'string', 'email','unique:users'],
            ]);
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($user->isDirty()) {
            $user->save();
            return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Perfil actualizado exitosamente!']]);
        }

        return redirect()->back();
    }
}
