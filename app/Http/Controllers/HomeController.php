<?php

namespace App\Http\Controllers;

use App\Http\Resources\Cms\Settigns\SliderResource;
use App\Http\Resources\Main\Home\MostSelledCollection;
use App\Mail\ContactForm;
use App\Models\Catalogs\Product;
use App\Models\Configs\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Home', [
            'products' => new MostSelledCollection(Product::where('stock', '>', 0)->inRandomOrder()->take(8)->get()),
            'slider' => new SliderResource(Slider::find(1)),
        ]);
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

        } catch (\Exception$e) {
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
