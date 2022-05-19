<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PasswordRequest;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class ChangePasswordController extends Controller
{
    /**
     * Display the change password view
     *
     * @return \Inertia\Response
     */
    public function __invoke()
    {
        return Inertia::render('Profile/ChangePassword');
    }

    public function store(PasswordRequest $request)
    {
        try {
            auth()->user()->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60)
            ])->save();

            event(new PasswordReset(auth()->user()));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors($th->getMessage())->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Contraseña actualizada exitosamente!']]);

    }
}
