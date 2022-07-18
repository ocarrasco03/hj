<?php

namespace App\Http\Controllers\Cms\Settings\Advanced;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImportController extends Controller
{
    public function index()
    {
        return Inertia::render('Cms/Settings/Advanced/Import');
    }

    public function executeImport(Request $request)
    {
        //
    }
}
