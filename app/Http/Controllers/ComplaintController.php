<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Notifications\NewComplaintNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function create()
    {
        // Require citizen login to file a complaint
        if (! auth('citizen')->check()) {
            return redirect()->route('citizen.login')
                ->with('error', 'Please log in to your citizen account to file a complaint.');
        }

        $citizen = auth('citizen')->user();

        // Block check
        if ($citizen->is_blocked) {
            auth('citizen')->logout();
            return redirect()->route('citizen.login')
                ->with('error', 'Your account has been blocked. You cannot file complaints.');
        }

        return view('public.complaint', compact('citizen'));
    }

    public function store(Request $request)
    {
        // Require citizen login
        if (! auth('citizen')->check()) {
            return redirect()->route('citizen.login')
                ->with('error', 'Please log in to file a complaint.');
        }

        $citizen = auth('citizen')->user();

        // Block check
        if ($citizen->is_blocked) {
            auth('citizen')->logout();
            return redirect()->route('citizen.login')
                ->with('error', 'Your account has been blocked.');
        }

        $validated = $request->validate([
            'shop_name'        => 'required|string|max:255',
            'location_address' => 'required|string|max:500',
            'description'      => 'required|string|min:20|max:2000',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'description.min' => 'Please provide at least 20 characters of description.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'citizen_id'       => $citizen->id,
            'citizen_name'     => $citizen->name,
            'citizen_phone'    => $citizen->phone,
            'shop_name'        => $validated['shop_name'],
            'location_address' => $validated['location_address'],
            'description'      => $validated['description'],
            'photo_path'       => $photoPath,
            'status'           => 'Pending',
        ]);

        // Send email notification to admin (if MAIL configured)
        try {
            $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL', 'admin@sastabazaar.pk'));
            Notification::route('mail', $adminEmail)
                ->notify(new NewComplaintNotification($complaint));
        } catch (\Throwable $e) {
            // Silently fail — email is non-critical
            logger()->warning('Complaint notification email failed: ' . $e->getMessage());
        }

        return redirect()->route('complaint.create')
            ->with('success', 'Your complaint has been submitted successfully. Reference #' . $complaint->id . '.');
    }
}