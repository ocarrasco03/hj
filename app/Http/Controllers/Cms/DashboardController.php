<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cms\Dashboard\OrdersCollection;
use App\Models\Sales\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = Carbon::now()->subDays(30);
        $users = User::where('created_at', '>', $days)->count();

        $visitors = [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            'data' => [50, 10, 120, 5, 35, 60, 115, 32, 43, 15, 22, 73],
        ];

        return Inertia::render('Cms/Dashboard', [
            'users' => $users,
            'visitors' => $visitors,
            'orders' => new OrdersCollection(Order::orderByDesc('updated_at')->limit(5)->get())]);
    }

    public function buildCharts()
    {
        //
    }
}
