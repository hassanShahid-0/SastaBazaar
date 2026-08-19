<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\DailyPrice;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', today()->toDateString());

        $commodities = Commodity::orderBy('name')->get();

        // Get existing prices for selected date indexed by commodity_id
        $existingPrices = DailyPrice::whereDate('active_date', $date)
            ->pluck('official_price', 'commodity_id')
            ->toArray();

        return view('admin.prices.index', compact('commodities', 'existingPrices', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'active_date' => 'required|date',
            'prices'      => 'required|array',
            'prices.*'    => 'nullable|numeric|min:0',
        ]);

        $date = $request->input('active_date');
        $prices = $request->input('prices', []);

        $count = 0;
        foreach ($prices as $commodityId => $price) {
            if ($price !== null && $price !== '') {
                DailyPrice::updateOrCreate(
                    [
                        'commodity_id' => $commodityId,
                        'active_date'  => $date,
                    ],
                    [
                        'official_price' => $price,
                    ]
                );
                $count++;
            }
        }

        return redirect()->route('admin.prices.index', ['date' => $date])
            ->with('success', "Successfully published $count official prices for $date.");
    }
}