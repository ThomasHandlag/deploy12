<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Carbon;
use App\Models\VerifyCode;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;

class VerifyEmailController extends Controller
{
    public function showOtpForm(Request $request): RedirectResponse | Response
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }
        
        return Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }

    /**
     * Handle the incoming OTP verification request.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        dd($request->user());
        $request->validate([
            'otp' => 'required|string',
        ]);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Find the latest valid, unused OTP for the user
        $otpRecord = $user->emailVerificationOtps()
            ->where('code', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if ($otpRecord) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }
            // Remove the OTP record after successful verification
            $otpRecord->delete();
            return redirect()->intended(route('dashboard', absolute: false))->with('status', 'email-verified');
        }

        // OTP is invalid or expired
        return back()->withErrors(['otp' => __('The code is invalid or has expired.')]);
    }

    /**
     * Resend the verification OTP email.
     */
    public function sendVerificationOtp(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $otpCode = Random::generate(6, '0-9');

        VerifyCode::create([
            'user_id' => $request->user()->id,
            'code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(1), // OTP expires in 10 minutes
        ]);
       
        Mail::to($request->user()->email)->send(new VerifyMail($otpCode));


        return back()->with('status', 'verification-code-sent');
    }
}
