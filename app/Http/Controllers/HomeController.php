<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Home');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Contact form method
     *
     * @param Request $request
     * @return void
     */
    public function sendContact(Request $request)
    {
        try {
            if (!$this->validDomain($request->input('email'))) {
                throw new Exception('Lo sentimos! Detectamos que tu email no es valido');
            }

            Mail::to('ocarrasco@hjautopartes.com.mx')->send(new ContactForm($request->input()));

        } catch (\Exception $e) {
            return Redirect::route('home')->with(['toast' => ['type' => 'danger', 'message' => $e->getMessage()]]);
        }

        return Redirect::route('home')->with(['toast' => ['type' => 'success', 'message' => 'Mensaje enviado']]);
    }

    public function corporate()
    {
        return Inertia::render('Corporate');
    }

    public function policy()
    {
        return Inertia::render('Markdown/Policy');
    }

    public function warranty()
    {
        return Inertia::render('Markdown/Warranty');
    }

    public function terms()
    {
        return Inertia::render('Markdown/TermsConditions');
    }

    protected function validDomain($email)
    {
        $domain = explode('@', $email);
        $domain = $domain[1];

        if (str_contains($domain, '.xyz') || str_contains($domain, 'example')) {
            return false;
        }

        return true;
    }
}
