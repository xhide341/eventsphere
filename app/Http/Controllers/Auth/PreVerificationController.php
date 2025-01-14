<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PreVerificationController extends Controller
{
    public function sendVerification(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email']
        ]);

        $email = $request->email;
        $token = md5($email . time());

        // Store in session with expiry
        Session::put("pre_verification_{$token}", [
            'email' => $email,
            'expires' => now()->addHours(1)
        ]);

        // Generate verification URL
        $url = URL::temporarySignedRoute(
            'pre.verification.verify',
            now()->addHours(1),
            ['token' => $token]
        );

        // Send verification email
        Mail::to($email)->send(new PreVerificationMail($url));

        return back()->with('status', 'verification-link-sent');
    }

    public function verify(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $token = $request->token;
        $data = Session::get("pre_verification_{$token}");

        if (!$data || now()->gt($data['expires'])) {
            return redirect()->route('register')
                ->with('error', 'Verification link expired');
        }

        // Store verified email for registration
        Session::put('verified_email', $data['email']);
        Session::forget("pre_verification_{$token}");

        return redirect()->route('register.form');
    }
}