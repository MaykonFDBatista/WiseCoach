<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Formats a password using the current encryption.
 *
 * @param   string   $plaintext     The plaintext password to encrypt.
 * @param   string   $salt          The salt to use to encrypt the password. []
 *                                  If not present, a new salt will be
 *                                  generated.
 * @param   string   $encryption    The kind of password encryption to use.
 *                                  Defaults to md5-hex.
 * @param   boolean  $show_encrypt  Some password systems prepend the kind of
 *                                  encryption to the crypted password ({SHA},
 *                                  etc). Defaults to false.
 *
 * @return  string  The encrypted password.
 *
 * @since   11.1
 */
if (!function_exists('getCryptedPassword')) {

    function getCryptedPassword($plaintext, $salt = '', $encryption = 'md5-hex', $show_encrypt = false) {
        // Get the salt to use.
        $salt = getSalt($encryption, $salt, $plaintext);

        // Encrypt the password.
        switch ($encryption) {
            case 'plain':
                return $plaintext;

            case 'sha':
                $encrypted = base64_encode(mhash(MHASH_SHA1, $plaintext));
                return ($show_encrypt) ? '{SHA}' . $encrypted : $encrypted;

            case 'crypt':
            case 'crypt-des':
            case 'crypt-md5':
            case 'crypt-blowfish':
                return ($show_encrypt ? '{crypt}' : '') . crypt($plaintext, $salt);

            case 'md5-base64':
                $encrypted = base64_encode(mhash(MHASH_MD5, $plaintext));
                return ($show_encrypt) ? '{MD5}' . $encrypted : $encrypted;

            case 'ssha':
                $encrypted = base64_encode(mhash(MHASH_SHA1, $plaintext . $salt) . $salt);
                return ($show_encrypt) ? '{SSHA}' . $encrypted : $encrypted;

            case 'smd5':
                $encrypted = base64_encode(mhash(MHASH_MD5, $plaintext . $salt) . $salt);
                return ($show_encrypt) ? '{SMD5}' . $encrypted : $encrypted;

            case 'aprmd5':
                $length = strlen($plaintext);
                $context = $plaintext . '$apr1$' . $salt;
                $binary = JUserHelper::_bin(md5($plaintext . $salt . $plaintext));

                for ($i = $length; $i > 0; $i -= 16) {
                    $context .= substr($binary, 0, ($i > 16 ? 16 : $i));
                }
                for ($i = $length; $i > 0; $i >>= 1) {
                    $context .= ($i & 1) ? chr(0) : $plaintext[0];
                }

                $binary = JUserHelper::_bin(md5($context));

                for ($i = 0; $i < 1000; $i++) {
                    $new = ($i & 1) ? $plaintext : substr($binary, 0, 16);
                    if ($i % 3) {
                        $new .= $salt;
                    }
                    if ($i % 7) {
                        $new .= $plaintext;
                    }
                    $new .= ($i & 1) ? substr($binary, 0, 16) : $plaintext;
                    $binary = JUserHelper::_bin(md5($new));
                }

                $p = array();
                for ($i = 0; $i < 5; $i++) {
                    $k = $i + 6;
                    $j = $i + 12;
                    if ($j == 16) {
                        $j = 5;
                    }
                    $p[] = JUserHelper::_toAPRMD5((ord($binary[$i]) << 16) | (ord($binary[$k]) << 8) | (ord($binary[$j])), 5);
                }

                return '$apr1$' . $salt . '$' . implode('', $p) . JUserHelper::_toAPRMD5(ord($binary[11]), 3);

            case 'md5-hex':
            default:
                $encrypted = ($salt) ? md5($plaintext . $salt) : md5($plaintext);
                return ($show_encrypt) ? '{MD5}' . $encrypted : $encrypted;
        }
    }

}
/**
 * Returns a salt for the appropriate kind of password encryption.
 * Optionally takes a seed and a plaintext password, to extract the seed
 * of an existing password, or for encryption types that use the plaintext
 * in the generation of the salt.
 *
 * @param   string  $encryption  The kind of password encryption to use.
 *                               Defaults to md5-hex.
 * @param   string  $seed        The seed to get the salt from (probably a
 *                               previously generated password). Defaults to
 *                               generating a new seed.
 * @param   string  $plaintext   The plaintext password that we're generating
 *                               a salt for. Defaults to none.
 *
 * @return  string  The generated or extracted salt.
 *
 * @since   11.1
 */
if (!function_exists('getSalt')) {

    function getSalt($encryption = 'md5-hex', $seed = '', $plaintext = '') {
        // Encrypt the password.
        switch ($encryption) {
            case 'crypt':
            case 'crypt-des':
                if ($seed) {
                    return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 2);
                } else {
                    return substr(md5(mt_rand()), 0, 2);
                }
                break;

            case 'crypt-md5':
                if ($seed) {
                    return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 12);
                } else {
                    return '$1$' . substr(md5(mt_rand()), 0, 8) . '$';
                }
                break;

            case 'crypt-blowfish':
                if ($seed) {
                    return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 16);
                } else {
                    return '$2$' . substr(md5(mt_rand()), 0, 12) . '$';
                }
                break;

            case 'ssha':
                if ($seed) {
                    return substr(preg_replace('|^{SSHA}|', '', $seed), -20);
                } else {
                    return mhash_keygen_s2k(MHASH_SHA1, $plaintext, substr(pack('h*', md5(mt_rand())), 0, 8), 4);
                }
                break;

            case 'smd5':
                if ($seed) {
                    return substr(preg_replace('|^{SMD5}|', '', $seed), -16);
                } else {
                    return mhash_keygen_s2k(MHASH_MD5, $plaintext, substr(pack('h*', md5(mt_rand())), 0, 8), 4);
                }
                break;

            case 'aprmd5': /* 64 characters that are valid for APRMD5 passwords. */
                $APRMD5 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

                if ($seed) {
                    return substr(preg_replace('/^\$apr1\$(.{8}).*/', '\\1', $seed), 0, 8);
                } else {
                    $salt = '';
                    for ($i = 0; $i < 8; $i++) {
                        $salt .= $APRMD5{rand(0, 63)};
                    }
                    return $salt;
                }
                break;

            default:
                $salt = '';
                if ($seed) {
                    $salt = $seed;
                }
                return $salt;
                break;
        }
    }

}
/**
 * Generate a random password
 *
 * @param   integer  $length  Length of the password to generate
 *
 * @return  string  Random Password
 *
 * @since   11.1
 */
if (!function_exists('genRandomPassword')) {

    function genRandomPassword($length = 8) {
        $salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $base = strlen($salt);
        $makepass = '';

        /*
         * Start with a cryptographic strength random string, then convert it to
         * a string with the numeric base of the salt.
         * Shift the base conversion on each character so the character
         * distribution is even, and randomize the start shift so it's not
         * predictable.
         */
        $random = genRandomBytes($length + 1);
        $shift = ord($random[0]);
        for ($i = 1; $i <= $length; ++$i) {
            $makepass .= $salt[($shift + ord($random[$i])) % $base];
            $shift += ord($random[$i]);
        }

        return $makepass;
    }

}
/**
 * Converts to allowed 64 characters for APRMD5 passwords.
 *
 * @param   string   $value  The value to convert.
 * @param   integer  $count  The number of characters to convert.
 *
 * @return  string  $value converted to the 64 MD5 characters.
 *
 * @since   11.1
 */
if (!function_exists('_toAPRMD5')) {

    function _toAPRMD5($value, $count) {
        /* 64 characters that are valid for APRMD5 passwords. */
        $APRMD5 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $aprmd5 = '';
        $count = abs($count);
        while (--$count) {
            $aprmd5 .= $APRMD5[$value & 0x3f];
            $value >>= 6;
        }
        return $aprmd5;
    }

}
/**
 * Converts hexadecimal string to binary data.
 *
 * @param   string  $hex  Hex data.
 *
 * @return  string  Binary data.
 *
 * @since   11.1
 */
if (!function_exists('_bin')) {

    function _bin($hex) {
        $bin = '';
        $length = strlen($hex);
        for ($i = 0; $i < $length; $i += 2) {
            $tmp = sscanf(substr($hex, $i, 2), '%x');
            $bin .= chr(array_shift($tmp));
        }
        return $bin;
    }

}

/**
 * Generate random bytes.
 *
 * @param   integer  $length  Length of the random data to generate
 *
 * @return  string  Random binary data
 *
 * @since  12.1
 */
if (!function_exists('genRandomBytes')) {

    function genRandomBytes($length = 16) {
        $sslStr = '';
        /*
         * if a secure randomness generator exists and we don't
         * have a buggy PHP version use it.
         */
        if (function_exists('openssl_random_pseudo_bytes')
                && (version_compare(PHP_VERSION, '5.3.4') >= 0 || IS_WIN)) {
            $sslStr = openssl_random_pseudo_bytes($length, $strong);
            if ($strong) {
                return $sslStr;
            }
        }

        /*
         * Collect any entropy available in the system along with a number
         * of time measurements of operating system randomness.
         */
        $bitsPerRound = 2;
        $maxTimeMicro = 400;
        $shaHashLength = 20;
        $randomStr = '';
        $total = $length;

        // Check if we can use /dev/urandom.
        $urandom = false;
        $handle = null;

        // This is PHP 5.3.3 and up
        if (function_exists('stream_set_read_buffer') && @is_readable('/dev/urandom')) {
            $handle = @fopen('/dev/urandom', 'rb');
            if ($handle) {
                $urandom = true;
            }
        }

        while ($length > strlen($randomStr)) {
            $bytes = ($total > $shaHashLength) ? $shaHashLength : $total;
            $total -= $bytes;
            /*
             * Collect any entropy available from the PHP system and filesystem.
             * If we have ssl data that isn't strong, we use it once.
             */
            $entropy = rand() . uniqid(mt_rand(), true) . $sslStr;
            $entropy .= implode('', @fstat(fopen(__FILE__, 'r')));
            $entropy .= memory_get_usage();
            $sslStr = '';
            if ($urandom) {
                stream_set_read_buffer($handle, 0);
                $entropy .= @fread($handle, $bytes);
            } else {
                /*
                 * There is no external source of entropy so we repeat calls
                 * to mt_rand until we are assured there's real randomness in
                 * the result.
                 *
                 * Measure the time that the operations will take on average.
                 */
                $samples = 3;
                $duration = 0;
                for ($pass = 0; $pass < $samples; ++$pass) {
                    $microStart = microtime(true) * 1000000;
                    $hash = sha1(mt_rand(), true);
                    for ($count = 0; $count < 50; ++$count) {
                        $hash = sha1($hash, true);
                    }
                    $microEnd = microtime(true) * 1000000;
                    $entropy .= $microStart . $microEnd;
                    if ($microStart > $microEnd) {
                        $microEnd += 1000000;
                    }
                    $duration += $microEnd - $microStart;
                }
                $duration = $duration / $samples;

                /*
                 * Based on the average time, determine the total rounds so that
                 * the total running time is bounded to a reasonable number.
                 */
                $rounds = (int) (($maxTimeMicro / $duration) * 50);

                /*
                 * Take additional measurements. On average we can expect
                 * at least $bitsPerRound bits of entropy from each measurement.
                 */
                $iter = $bytes * (int) ceil(8 / $bitsPerRound);
                for ($pass = 0; $pass < $iter; ++$pass) {
                    $microStart = microtime(true);
                    $hash = sha1(mt_rand(), true);
                    for ($count = 0; $count < $rounds; ++$count) {
                        $hash = sha1($hash, true);
                    }
                    $entropy .= $microStart . microtime(true);
                }
            }

            $randomStr .= sha1($entropy, true);
        }

        if ($urandom) {
            @fclose($handle);
        }

        return substr($randomStr, 0, $length);
    }

}