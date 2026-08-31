<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        $query = Citizen::withCount('complaints')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_blocked', $request->input('status') === 'blocked');
        }

        $citizens = $query->paginate(20)->withQueryString();
        $totalCitizens  = Citizen::count();
        $blockedCount   = Citizen::where('is_blocked', true)->count();

        return view('admin.citizens.index', compact('citizens', 'totalCitizens', 'blockedCount'));
    }

    public function toggleBlock(Request $request, Citizen $citizen)
    {
        if ($citizen->is_blocked) {
            // Unblock
            $citizen->update([
                'is_blocked'     => false,
                'blocked_reason' => null,
                'blocked_at'     => null,
            ]);
            $message = "Citizen #{$citizen->id} ({$citizen->name}) has been unblocked.";
        } else {
            // Block
            $request->validate([
                'blocked_reason' => 'nullable|string|max:500',
            ]);
            $citizen->update([
                'is_blocked'     => true,
                'blocked_reason' => $request->input('blocked_reason'),
                'blocked_at'     => now(),
            ]);
            $message = "Citizen #{$citizen->id} ({$citizen->name}) has been blocked.";
        }

        return redirect()->route('admin.citizens.index')->with('success', $message);
    }
}
