<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();
        $svgContent = $google2fa->getQRCodeInline(
            'Social Hub Manager',
            $user->email,
            $secretKey
        );

        // Convert SVG to Data URI
        $qrCodeUrl = 'data:image/svg+xml;base64,' . base64_encode($svgContent);

        return view('two_factor.create', [
            'qrCodeUrl' => $qrCodeUrl,
            'secretKey' => $secretKey
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'secret' => 'required|string'
        ]);

        if ($this->validateOtp($request->secret, $request->otp)) {
            $user = User::find(auth()->user()->id);
            $user->two_factor_secret = $request->secret;
            $user->uses_two_factor = true;
            $request->session()->put('two_factor_authenticated', true);
            $user->save();

            return redirect('/')->with('success', 'Two factor authentication enabled successfully.');
        }


        return redirect('/two-factor/activate')->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    public function edit()
    {
        return view('two_factor.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = User::find(session('2fa:user:id'));

        if (!$user) {
            return redirect('/login')->withErrors(['email' => 'Unable to find user for 2FA verification.']);
        }

        if ($this->validateOtp($user->two_factor_secret, $request->otp)) {
            Auth::login($user);
            session()->forget('2fa:user:id');
            $request->session()->put('two_factor_authenticated', true);

            return redirect('/')->with('success', '2FA verification successful.');
        }

        return redirect('/two-factor/verify')->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    public function destroy(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->two_factor_secret = null;
        $user->uses_two_factor = false;
        $user->save();

        return redirect('/')->with('success', 'Two factor authentication disabled successfully.');
    }

    protected function validateOtp($two_factor_secret, $otp)
    {
        $google2fa = new Google2FA();
        $window = config('google2fa.window');
        return $google2fa->verifyKey($two_factor_secret, $otp, $window);
    }
}
