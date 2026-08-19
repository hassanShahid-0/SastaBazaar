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
        return view('public.complaint');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'citizen_name'     => 'required|string|max:255',
            'citizen_phone'    => ['required', 'string', 'regex:/^03[0-9]{9}$/'],
            'shop_name'        => 'required|string|max:255',
            'location_address' => 'required|string|max:500',
            'description'      => 'required|string|min:20|max:2000',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'citizen_phone.regex' => 'Phone must be a valid Pakistani mobile number (e.g. 03001234567).',
            'description.min'     => 'Please provide at least 20 characters of description.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'citizen_name'     => $validated['citizen_name'],
            'citizen_phone'    => $validated['citizen_phone'],
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