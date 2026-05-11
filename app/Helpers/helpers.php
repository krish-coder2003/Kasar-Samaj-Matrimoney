<?php

if (!function_exists('generateOtp')) {
    /**
     * Generate a numeric OTP of a given length.
     *
     * @param int $length
     * @return int
     */
    function generateOtp($length = 6)
    {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return rand($min, $max);
    }
}

if (!function_exists('formatAge')) {
    /**
     * Calculate age from a date of birth.
     *
     * @param string|null $dob
     * @return string
     */
    function formatAge($dob)
    {
        if (!$dob) return 'N/A';
        return \Carbon\Carbon::parse($dob)->age . ' yrs';
    }
}
