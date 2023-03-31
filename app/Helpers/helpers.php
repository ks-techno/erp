<?php
if (!function_exists('numberToWords')) {
    function numberToWords($number) {
        $words = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return 'minus ' . numberToWords(abs($number));
        }

        $string = '';

        if ($number < 21) {
            $string = $words[$number];
        } elseif ($number < 100) {
            $tens = (int)($number / 10) * 10;
            $units = $number % 10;
            $string = $words[$tens];
            if ($units) {
                $string .= ' ' . $words[$units];
            }
        } elseif ($number < 1000) {
            $hundreds = (int)($number / 100);
            $remainder = $number % 100;
            $string = $words[$hundreds] . ' hundred';
            if ($remainder) {
                $string .= ' and ' . numberToWords($remainder);
            }
        } elseif ($number < 1000000) {
            $thousands = (int)($number / 1000);
            $remainder = $number % 1000;
            $string = numberToWords($thousands) . ' thousand';
            if ($remainder) {
                $string .= ' ';
                if ($remainder < 100) {
                    $string .= 'and ';
                }
                $string .= numberToWords($remainder);
            }
        } else {
            $millions = (int)($number / 1000000);
            $remainder = $number % 1000000;
            $string = numberToWords($millions) . ' million';
            if ($remainder) {
                $string .= ' ';
                if ($remainder < 100) {
                    $string .= 'and ';
                }
                $string .= numberToWords($remainder);
            }
        }

        return $string;
    }
}
if (!function_exists('format_number')) {
    function format_number($number) {
        if (floor($number) == $number) {
            return number_format($number,0);
           } else {
            return number_format($number,2);
           }
    }
}
