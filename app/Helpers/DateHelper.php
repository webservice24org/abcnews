<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatBanglaDateTime($datetime, $showTime = true)
{
    $months = [
        'January' => 'জানুয়ারি',
        'February' => 'ফেব্রুয়ারি',
        'March' => 'মার্চ',
        'April' => 'এপ্রিল',
        'May' => 'মে',
        'June' => 'জুন',
        'July' => 'জুলাই',
        'August' => 'আগস্ট',
        'September' => 'সেপ্টেম্বর',
        'October' => 'অক্টোবর',
        'November' => 'নভেম্বর',
        'December' => 'ডিসেম্বর',
    ];

    $banglaDigits = ['0','1','2','3','4','5','6','7','8','9'];
    $banglaConvertedDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

    $date = Carbon::parse($datetime);

    $day = str_replace($banglaDigits, $banglaConvertedDigits, $date->format('d'));
    $month = $months[$date->format('F')];
    $year = str_replace($banglaDigits, $banglaConvertedDigits, $date->format('Y'));

    $result = "{$day} {$month} {$year}";

    if ($showTime) {
        $time = str_replace($banglaDigits, $banglaConvertedDigits, $date->format('H:i'));
        $result .= ", {$time}";
    }

    return $result;
}

}
