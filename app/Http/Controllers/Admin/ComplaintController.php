<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Complaint::latest();

        if ($status !== 'all') {
            $query->where('status', ucfirst($status));
        }

        $complaints = $query->paginate(15)->withQueryString();

        $totalComplaints  = Complaint::count();
        $pendingCount     = Complaint::where('status', 'Pending')->count();
        $resolvedCount    = Complaint::where('status', 'Resolved')->count();
        $topShop          = Complaint::select('shop_name', \DB::raw('count(*) as total'))
            ->groupBy('shop_name')
            ->orderByDesc('total')
            ->first();

        return view('admin.complaints.index', compact(
            'complaints', 'status',
            'totalComplaints', 'pendingCount', 'resolvedCount', 'topShop'
        ));
    }

    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function toggleStatus(Complaint $complaint)
    {
        $complaint->status = $complaint->isPending() ? 'Resolved' : 'Pending';
        $complaint->save();

        return redirect()->back()
            ->with('success', "Complaint # {$complaint->id}  marked as {$complaint->status}.");
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }
}