<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\DailyPrice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', today()->toDateString());

        $commodities = Commodity::with(['dailyPrices' => function ($query) use ($date) {
            $query->whereDate('active_date', $date);
        }])->orderBy('name')->get();

        $latestUpdate = DailyPrice::whereDate('active_date', $date)
            ->latest('updated_at')
            ->value('updated_at');

        return view('public.home', compact('commodities', 'date', 'latestUpdate'));
    }
}