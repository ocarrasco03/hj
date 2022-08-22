<?php

namespace App\Http\Controllers\Cms\Settings\Advanced;

use App\Http\Controllers\Controller;
use App\Imports\Catalogs\ApplicationImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return Inertia::render('Cms/Settings/Advanced/Import');
    }

    public function executeImport(Request $request)
    {
        if ($request->type === 'file') {
            switch ($request->target) {
                case 'app-catalog':
                    Excel::queueImport(new ApplicationImport, $request->file('file'));
                    break;
                case 'product':
                    # code...
                    break;
                case 'prices':
                    # code...
                    break;
                case 'stocks':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            //
        }
    }
}
