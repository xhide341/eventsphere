<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return redirect()->route('register')
                ->with('error', 'Invalid verification link');
        }

        $pendingUser = Session::get('pending_user');

        if (!$pendingUser) {
            return redirect()->route('register')
                ->with('error', 'Registration session expired');
        }

        // Create verified user
        $user = User::create([
            'name' => $pendingUser['name'],
            'email' => $pendingUser['email'],
            'password' => $pendingUser['password'],
            'email_verified_at' => now(),
            'role' => $pendingUser['role']
        ]);

        Session::forget('pending_user');
        Auth::login($user);

        return redirect()->route('events');
    }
}
