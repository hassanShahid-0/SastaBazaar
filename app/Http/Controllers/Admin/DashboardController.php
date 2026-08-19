<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\DailyPrice;

class DashboardController extends Controller
{
    public function index()
    {
        $commoditiesCount  = Commodity::count();
        $pricesTodayCount  = DailyPrice::whereDate('active_date', today())->count();
        $complaintsCount   = \App\Models\Complaint::count();
        $pendingComplaints = \App\Models\Complaint::where('status', 'pending')->count();
        $latestUpdate      = DailyPrice::latest()->value('updated_at');

        return view('admin.dashboard', compact(
            'commoditiesCount',
            'pricesTodayCount',
            'complaintsCount',
            'pendingComplaints',
            'latestUpdate'
        ));
    }
}
