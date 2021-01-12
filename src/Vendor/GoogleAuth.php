<?php
declare(strict_types=1);
namespace ParagonIE\MultiFactor\Vendor;

use \ParagonIE\ConstantTime\Base32;
use ParagonIE\MultiFactor\OneTime;
use \ParagonIE\MultiFactor\OTP\{
    HOTP,
    TOTP
};

/**
 * Class GoogleAuth
 * @package ParagonIE\MultiFactor\Vendor
 */
class GoogleAuth extends OneTime
{
    public function makeQRCodeMessage(
        string $username = '',
        string $issuer = '',
        string $label = '',
        int $initialCounter = 0
    ) {
        if ($this->otp instanceof TOTP) {
            $message = 'otpauth://totp/';
        } elseif ($this->otp instanceof HOTP) {
            $message = 'otpauth://hotp/';
        } else {
            throw new \Exception('Not implemented');
        }
        if ($label) {
            $message .= \urlencode(
                \str_replace(':', '', $label)
            );
            $message .= ':';
        }
        $message .= \urlencode($username);
        $args = [
            'secret' => Base32::encode($this->secretKey->getString())
        ];
        if ($issuer) {
            $args['issuer'] = $issuer;
        }
        $args['digits'] = $this->otp->getLength();
        if ($this->otp instanceof TOTP) {
            $args['period'] = $this->otp->getTimeStep();
        } else {
        /* // psalm 1.1.9 identifies this as a redundant condition
        } elseif ($this->otp instanceof HOTP) {
        */
            $args['counter'] = $initialCounter;
        }
        $message .= '?' . \http_build_query($args);

        return $message;
    }
}
