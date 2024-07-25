<?php

namespace App\Services;

use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorService
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    public function generateSecretKey()
    {
        return $this->google2fa->generateSecretKey();
    }

    public function getQRCodeUrl($company, $email, $secretKey)
    {
        $svgContent = $this->google2fa->getQRCodeInline($company, $email, $secretKey);
        return 'data:image/svg+xml;base64,' . base64_encode($svgContent); // Convert SVG to Data URI
    }

    public function validateOtp($secret, $otp)
    {
        $window = config('google2fa.window');
        return $this->google2fa->verifyKey($secret, $otp, $window);
    }
}
