<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Registration ──────────────────────────────────────────────────────────

    public function registerForm()
    {
        if (auth('citizen')->check()) {
            return redirect()->route('home');
        }
        return view('citizen.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => ['required', 'string', 'regex:/^03[0-9]{9}$/', 'unique:citizens,phone'],
            'email'    => 'nullable|email|max:255|unique:citizens,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'phone.regex'  => 'Phone must be a valid Pakistani mobile number (e.g. 03001234567).',
            'phone.unique' => 'This phone number is already registered.',
        ]);

        $citizen = Citizen::create([
            'name'     => $validated['name'],
            'phone'    => $validated['phone'],
            'email'    => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        auth('citizen')->login($citizen);

        return redirect()->route('home')
            ->with('success', 'Welcome, ' . $citizen->name . '! Your citizen account has been created.');
    }

    // ── Login ─────────────────────────────────────────────────────────────────

    public function loginForm()
    {
        if (auth('citizen')->check()) {
            return redirect()->route('home');
        }
        return view('citizen.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone'    => 'required|string',
            'password' => 'required|string',
        ]);

        if (! auth('citizen')->attempt(['phone' => $credentials['phone'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('phone'))
                ->withErrors(['phone' => 'These credentials do not match our records.']);
        }

        $citizen = auth('citizen')->user();

        // Immediately check if blocked after login
        if ($citizen->is_blocked) {
            auth('citizen')->logout();
            $reason = $citizen->blocked_reason ? ' Reason: ' . $citizen->blocked_reason : '';
            return back()
                ->withInput($request->only('phone'))
                ->withErrors(['phone' => 'Your account has been blocked by the administration.' . $reason]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('success', 'Welcome back, ' . $citizen->name . '!');
    }

    // ── Logout ────────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        auth('citizen')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}
