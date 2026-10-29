<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show dedicated staff login form.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isStaff()) {
            return redirect()->route('staff.scanner');
        }

        return view('staff.auth.login');
    }

    /**
     * Handle staff authentication attempt.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $normalizedEmail = trim(strtolower($credentials['email']));

        if (! Auth::attempt(['email' => $normalizedEmail, 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Kredensial yang dimasukkan tidak cocok dengan data staf terdaftar.',
                ]);
        }

        $user = Auth::user();

        // Enforce staff/admin role check
        if (! $user->isStaff()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda tidak memiliki hak akses operasional staf acara.',
            ]);
        }

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        return redirect()->intended(route('staff.scanner'));
    }

    /**
     * Log staff member out and invalidate session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('staff.login')
            ->with('status', 'Sesi staf telah berhasil diakhiri.');
    }
}
