<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    protected $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    public function create()
    {
        $user = auth()->user();

        if (!session()->has('two_factor_secret')) {
            $secretKey = $this->twoFactorService->generateSecretKey();
            session(['two_factor_secret' => $secretKey]);
        } else {
            $secretKey = session('two_factor_secret');
        }

        $qrCodeUrl = $this->twoFactorService->getQRCodeUrl('Social Hub Manager', $user->email, $secretKey);

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

        if ($this->twoFactorService->validateOtp($request->secret, $request->otp)) {
            $user = User::find(auth()->user()->id);
            $user->two_factor_secret = $request->secret;
            $user->uses_two_factor = true;
            $user->save();

            session()->forget('two_factor_secret');
            $request->session()->put('two_factor_authenticated', true);

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

        if ($this->twoFactorService->validateOtp($user->two_factor_secret, $request->otp)) {
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
}
