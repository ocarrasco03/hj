<?php

namespace App\Http\Controllers\Cms\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $information = [
            'server' => [
                'php' => phpversion(),
                'version' => $_SERVER['SERVER_SOFTWARE'],
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
            ],
            'store' => [
                'version' => '2.0.0',
                'url' => $_SERVER['HTTP_HOST'],
                'path' => $_SERVER['DOCUMENT_ROOT'],
            ],
            'database' => [
                'connection' => env('DB_CONNECTION'),
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'username' => env('DB_USERNAME'),
                'prefix' => env('DB_PREFIX'),
            ],
            'mail' => [
                'type' => env('MAIL_MAILER'),
                'server' => env('MAIL_HOST'),
                'port' => env('MAIL_PORT'),
                'encrypt' => env('MAIL_ENCRYPTION'),
                'from' => env('MAIL_FROM_ADDRESS'),
            ],
            'customer' => [
                'browser' => $_SERVER['HTTP_USER_AGENT'],
                'ip' => request()->ip(),
            ],
        ];
        return Inertia::render('Cms/Settings/Info', ['information' => $information]);
    }
}
