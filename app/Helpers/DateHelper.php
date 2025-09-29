<?php

namespace App\Helpers;

use Carbon\Carbon;


class DateHelper
{
    public static function formatBanglaDateTime($datetime, $showTime = false)
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

        $days = [
            'Saturday'  => 'শনিবার',
            'Sunday'    => 'রবিবার',
            'Monday'    => 'সোমবার',
            'Tuesday'   => 'মঙ্গলবার',
            'Wednesday' => 'বুধবার',
            'Thursday'  => 'বৃহস্পতিবার',
            'Friday'    => 'শুক্রবার',
        ];

        $banglaDigits = ['0','1','2','3','4','5','6','7','8','9'];
        $banglaConvertedDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        $date = Carbon::parse($datetime);

        $dayName = $days[$date->format('l')];
        $day = str_replace($banglaDigits, $banglaConvertedDigits, $date->format('d'));
        $month = $months[$date->format('F')];
        $year = str_replace($banglaDigits, $banglaConvertedDigits, $date->format('Y'));

        $result = "{$dayName} । {$month} {$day}, {$year}";

        if ($showTime) {
            $time = str_replace($banglaDigits, $banglaConvertedDigits, $date->format('h:i A'));
            $result .= " ({$time})";
        }

        return $result;
    }
}
