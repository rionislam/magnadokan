<?php
namespace Core\Utilities;
class NumberFormatter{
    public static function formatNumber($number){
        if ($number >= 1e12) {  // 1 trillion or more
            $formattedNumber = round($number / 1e12, 2);
            $formattedNumber .= 'T';
        } elseif ($number >= 1e9) {  // 1 billion or more
            $formattedNumber = round($number / 1e9, 2);
            $formattedNumber .= 'B';
        } elseif ($number >= 1e6) {  // 1 million or more
            $formattedNumber = round($number / 1e6, 2);
            $formattedNumber .= 'M';
        } elseif ($number >= 1000) {  // 1 thousand or more
            $formattedNumber = round($number / 1000, 2);
            $formattedNumber .= 'k';
        } else {
            $formattedNumber = $number;
        }

        return $formattedNumber;
    } 
}