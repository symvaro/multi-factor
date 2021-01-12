# Multi-Factor

Fork of [paragonie/multi_factor](https://github.com/paragonie/multi_factor).
Designed to be a vendor-agnostic implementation of various Two-Factor 
Authentication solutions.

Initially developed by [Paragon Initiative Enterprises](https://paragonie.com) for use
in their own projects. Forked to remove the barcode writer dependency.

It's released under a dual license: GPL and MIT. As with
all dual-licensed projects, feel free to choose the license that fits your
needs.

## Requirements

* PHP 7
  * As per [Paragon Initiative Enterprise's commitment to open source](https://paragonie.com/blog/2016/04/go-php-7-our-commitment-maintaining-our-open-source-projects),
    all new software will no longer be written for PHP 5.

## Installing

```sh
composer require symvaro/multi-factor
```

## Example Usage

```php
<?php
use ParagonIE\MultiFactor\OneTime;
use ParagonIE\MultiFactor\OTP\TOTP;

$seed = random_bytes(20);

// You can use TOTP or HOTP
$otp = new OneTime($seed, new TOTP());

if (\password_verify($_POST['password'], $storedHash)) {
    if ($otp->validateCode($_POST['2facode'])) {
        // Login successful    
    }
}
```
